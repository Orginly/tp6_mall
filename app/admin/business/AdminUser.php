<?php

namespace app\admin\business;

use think\Exception;
use app\common\model\mysql\AdminUser as AdminUserModel;
class AdminUser
{
    /**
     * 用户登录逻辑层
     * @param $data
     * @return bool
     * @throws Exception
     */
    public static function login($data)
    {
        try {
            $adminUser = new AdminUserModel();
            $user = self::getAdminUserByUsername($data['username']);
            if(!$user){
                throw new Exception('不存在用户');
            }
            //判断密码是否正确
            if ($user['password'] != md5($data['password'])) {
                throw new Exception('密码错误');
            }

            //记录登录信息到mysql
            $updateData = [
                'last_time' => time(),
                'last_ip' => request()->ip(),//获取ip
            ];
            $res = $adminUser->updateById($user['id'], $updateData);
            if (!$res) {
                throw new Exception('登录失败');
            }
        } catch (\Exception $e) {
            // todo 记录日志 $e->getMessage();
            throw new Exception($e->getMessage());
        }

        //保存session
        unset($user['password']);
        session(config('admin.session_admin'), $user);
        return true;
    }

    /**
     * 通过用户名获取用户信息
     * @param $username
     * @return array|bool
     */
    public static function getAdminUserByUsername($username)
    {
        //获取用户数据
        $adminUser = new AdminUserModel();
        $user = $adminUser->getByUsername($username);
        if (empty($user) || $user->status != config('status.mysql.table_normal')) {
            return false;
        }
        return $user->toArray();
    }
}