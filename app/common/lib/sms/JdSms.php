<?php
//开启严格模式
declare(strict_types=1);
namespace app\common\lib\sms;
class JdSms {
    public static function sendCode(string $phone, int $code):bool
    {
        return true;
    }
}