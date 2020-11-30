<?php
declare(strict_types=1);

namespace app\common\lib;
/**
 * 关于数字的工具类
 * Class Number
 * @package app\common\lib
 */
class Number
{
    /**
     * 获取随机验证码
     * @param int $len 验证码个数
     * @return int
     */
    public static function getCode(int $len = 6): int
    {
        $code = rand(100000,999999);
        if($len == 4){
            $code = rand(1000,9999);
        }
        return  $code;
    }
}