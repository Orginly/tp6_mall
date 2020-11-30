<?php
declare(strict_types=1);

namespace app\common\business;

use app\common\lib\ClassArr;
use app\common\lib\Number;
use app\common\lib\sms\AliSms;

class Sms
{
    /**
     * 发送验证码Api
     * @param string $phone 手机号
     * @param int $codeLen 验证码位数
     * @param string $type 服务商 ali,jd,baidu
     * @return bool
     * @throws \ReflectionException
     */
    public static function sendCode(string $phone, int $codeLen, string $type = 'ali'): bool
    {
        //随机的验证码
        $code = Number::getCode($codeLen);
        //调用发送验证码
     /*   if (!AliSms::sendCode($phone, $code)) {
            return false;
        }*/

        ////基础工厂模式调用服务商
      /*  $type = ucfirst($type);//首字母大写
        //获取类的命名空间
        $server = 'app\common\lib\sms\\'.$type.'Sms';
        $result = $server::sendCode($phone,$code);//调用类下的sendCode*/

        //反射机制处理工厂模式
        $classArr = ClassArr::smsClassStat();
        //初始化工厂
        $classObj = ClassArr::initClass($type,$classArr,[],false);
        $result = $classObj::sendCode($phone,$code);
        if(!$result){
            return false;
        }
        //把短信验证码存入Redis中 并给出一个失效时间
        //名称 值  有效期
        cache(config('redis.code_pre') . $phone, $code, config('redis.code_expire'));
        return true;
    }
}