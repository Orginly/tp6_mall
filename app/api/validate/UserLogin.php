<?php

namespace app\api\validate;

use think\Validate;

class UserLogin extends Validate
{
    protected $rule = [
        'username' => 'require',
        'phone' => 'require|mobile',
        'code' => 'require|number',
        //'expire_type' => ['require','in'=>[1,2]]
        'expire_type' => 'require|in:1,2,3',
        'sex' => 'require|in:0,1,2'
    ];
    protected $message = [
        'username' => '用户名不得为空',
        'phone.require' => '手机号不得为空',
        'phone.mobile' => '手机号格式错误',
        'code.require' => '验证码不能为空',
        'code.number'  => '验证码错误',
        'expire_type.require' => '过期类型不得为空',
        'expire_type.in' => '过期类型格式错误',
    ];
    //场景
    protected $scene = [
        'phone_send' => ['phone'],
        'phone_login' => ['phone','code','expire'],//手机号登录
        'username_login' => ['username'],
        'update_userInfo' => ['username','sex']
    ];
}