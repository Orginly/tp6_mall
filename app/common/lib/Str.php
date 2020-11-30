<?php
declare(strict_types=1);
namespace app\common\lib;
class Str
{
    /**
     * 生成一个40位随机的的字符串Token
     * @param $string
     * @return string
     */
    public static function getLoginToken($string):string
    {
        //生成一个不会重复的字符串
        $str = md5(uniqid(md5(microtime()),true));
        //返回一个sha1加密的40位字符串
        return sha1($string.$str);
    }
}