<?php
declare(strict_types=1);

namespace app\common\business;

use app\common\lib\Str;
use app\common\lib\Time;
use think\Exception;
use think\facade\Log;

class User
{
    protected $userObj = null;//保存用户表model

    public function __construct()
    {
        //获取用户表模型
        $this->userObj = new \app\common\model\mysql\User();
    }

    /**
     * 用户登录
     * @param string $phone
     * @param int $code
     * @param int $expireType
     * @return array|bool
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login(string $phone, int $code, int $expireType)
    {
        //获取存放在redis的验证码
        $redisCode = cache(config('redis.code_pre') . $phone);
        if (!$redisCode || $redisCode != $code) {
            throw new Exception('验证码不正确');
        }
        //如果用户表中不存在则添加记录
        $user = $this->userObj->getUserByPhone($phone);
        //添加记录
        if (!$user) {
            $data = [
                'username' => 'Mo-' . substr($phone, -4) . rand(10, 99),
                'phone' => $phone,
                'session_type' => $expireType,//1为1天 2为7 3为30天
                'status' => config('status.mysql.table_normal'),//用户状态
                'last_time' => time(),
                'last_ip' => request()->ip(),
            ];
            //数据库语句都需要try
            try {

                $this->userObj->save($data);
                $userId = $this->userObj->id;
                $username = $this->userObj->username;

            } catch (\Exception $e) {
                //记录日志
                Log::info("user-login-{$user}-addUser" . $e->getMessage());
                throw new Exception('数据库内部异常');
            }
        } else {
            try {
                $user->save([
                    'last_time' => time(),
                    'last_ip' => request()->ip()
                ]);
                $userId = $user->id;
                $username = $user->username;
            } catch (\Exception $e) {
                //记录日志
                Log::info("user-login-{$user}-updateUser" . $e->getMessage());
                throw new Exception('数据库内部异常');
            }

        }
        //获取token
        $token = Str::getLoginToken($phone);
        //需要保存的数据
        $redisData = [
            'id' => $userId,
            'username' => $username,
        ];
        //设置Redis
        $result = cache(config('redis.token_pre') . $token, $redisData, Time::userLoginExpireTime($expireType));
        return $result ? ['token' => $token, 'username' => $username] : false;
    }

    /**
     * 获取状态正常用户的数据
     * @param $id,用户id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalUserById(int $id)
    {
        $user = $this->userObj->getUserById($id);
        //如果不是正常用户
        if(!$user || $user->status != config('status.mysql.table_normal')){
            return [];
        }
        unset($user->password);
        return $user->toArray();
    }

    /**
     * 更新用户信息
     * @param int $id 用户id
     * @param array $data 用户数据
     * @return bool|\think\response\Json
     */
    public function updateUser(int $id,array $data)
    {
        //判断用户是否存在
        $userInfo = $this->getNormalUserById($id);
        if(!$userInfo){
            throw new Exception('用户不存在');
        }
        //判断用户名不得与其他用户一致
        $user = $this->userObj->getUserByUsername($data['username']);
        if($user){
            throw new Exception('用户名称不能重复');
        }
        try {
            $this->userObj->updateById($id,$data);
        }catch(Exception $e){
            Log::info('user-update-updateUser-id='.$id.$e->getMessage());
            return showJson('error','数据库内部异常');
        }
        return true;
    }

}