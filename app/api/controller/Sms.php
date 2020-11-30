<?php
declare(strict_types=1);
namespace app\api\controller;
use app\api\validate\UserLogin;
use app\BaseController;
use think\exception\ValidateException;
use app\common\business\Sms as SmsBusiness;

class Sms extends BaseController {
    public function sendcode():object
    {
        //获取请求的手机号
        $phone = input('phone','','trim');
        $data = [
          'phone' => $phone
        ];
        try {
            //验证器助手函数
            validate(UserLogin::class)->scene('phone_send')->check($data);
        }catch(ValidateException $e){
            return showJson('error',$e->getMessage(),400);
        }

        //调用business业务层数据
       if(!SmsBusiness::sendCode($phone,6,'ali')){
           return showJson('success', '发送失败', null);
       }
        return showJson('success', '发送成功', null);
    }
}