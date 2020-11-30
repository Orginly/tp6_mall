<?php

namespace app\admin\validate;

use think\Validate;

class AdminUserValidate extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha'  => 'captcha',
    ];
    protected $message = [
        'username.request' => '用户名不得为空',
        'password.request' => '密码不得为空',
        'captcha' => '验证码错误!',
    ];
}