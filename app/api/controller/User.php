<?php
declare(strict_types=1);
namespace app\api\controller;
use app\api\validate\UserLogin;
use app\common\business\User as UserBis;
use think\exception\ValidateException;

class User extends AuthBase
{
    /**
     * 获取用户数据
     * @return object
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index():object
    {
        $user = (new UserBis())->getNormalUserById((int)$this->userId);
        return showJson('success','ok',$user);
    }

    public function update()
    {
        $username = request()->put('username','','trim');
        $sex = request()->put('sex','','intval');
        $data = [
            'username' => $username,
            'sex' => $sex
        ];
        //验证表单数据
        try {
            validate(UserLogin::class)->scene('update_userInfo')->check($data);
        }catch(ValidateException $e){
            return $this->showJson('error',$e->getMessage());
        }
        $res = (new UserBis())->updateUser((int)$this->userId,$data);
        if(!$res){
            return showJson('error','更新用户信息失败');
        }
        return showJson('success','更新用户信息成功');

    }
}