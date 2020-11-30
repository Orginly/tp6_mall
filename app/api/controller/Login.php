<?php
declare(strict_types=1);
namespace app\api\controller;

use app\api\validate\UserLogin;
use app\BaseController;
use app\common\business\User;
use app\Request;
use think\Exception;
use think\exception\ValidateException;

class Login extends BaseController
{
    public function index(Request $request):object
    {
        //获取表单数据
        $data = [
            'phone' => $request->post('phone','','trim'),
            'code' => $request->post('code','','intval'),
            'expire_type' => $request->post('expire_type',1,'intval'),
        ];
        //验证表单
        try {
            validate(UserLogin::class)->scene('phone_login')->check($data);
        }catch(ValidateException $e){
            return showJson('error',$e->getMessage());
        }

        //调用业务层
        try {
            $result = (new User())->login($data['phone'], $data['code'], $data['expire_type']);
        }catch(Exception $e){
            return showJson('error',$e->getMessage());

        }
        if(!$result){
            return showJson('error','登录失败');
        }
        return showJson('success','登录成功',$result);
    }
}