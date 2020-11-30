<?php

namespace app\admin\controller;

use app\admin\validate\AdminUserValidate;
use app\BaseController;
use app\common\model\mysql\AdminUser;
use think\facade\View;
use think\Request;


class Login extends BaseController
{
    public function index()
    {
        return View::fetch();
    }

    /**
     * 登录验证
     * @param Request $request
     * @param AdminUser $adminUser
     * @return \think\response\Json
     */
        public function loginCheck(Request $request, AdminUser $adminUser)
    {
        if (!$request->isPost()) {
            return showJson('error', '请求方式错误', null);
        }
        $username = $request->post('username', '', 'trim');
        $password = $request->post('password', '', 'trim');
        $captcha = $request->post('captcha', '', 'trim');
        $userData = [
            'username' => $username,
            'password' => $password,
            'captcha' => $captcha,
        ];
        //验证器验证数据
        $validate = new AdminUserValidate();
        if (!$validate->check($userData)) {
            return showJson('error', $validate->getError());
        }

        //捕获business业务逻辑层抛出的异常
        try {
            $ret = \app\admin\business\AdminUser::login($userData);
        } catch (\Exception $e) {
            return showJson('error', $e->getMessage(), null);
        }
        return showJson('success', '登录成功', null);

    }

    /**
     * 退出登录
     * @return \think\response\Redirect
     */
    public function logout()
    {
        session(config('admin.session_admin'), null);
        return redirect(url('login/index'));
    }
}