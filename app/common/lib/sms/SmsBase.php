<?php
declare(strict_types=1);
namespace app\common\lib\sms;
/**
 * 短信服务接口
 * Interface SmsBase
 * @package app\common\lib\sms
 */
interface SmsBase
{
    /**
     * 未实现的发送短信方法
     * @param string $phone 手机号码
     * @param int $code 随机验证码
     * @return mixed
     */
    public static function sendCode(string $phone, int $code);
}