<?php
declare(strict_types=1);
namespace app\common\lib;
class Time
{
    public static function userLoginExpireTime($type = 1):int
    {
        //如果类型不在这之间
        $type = !in_array($type, [1, 2, 3]) ? 1 : $type;
        if($type == 1){
            $day = $type;
        }else if($type == 2){
            $day = $type * 7;
        }else if($type == 3){
            $day = $type * 30;
        }
        return $day * 24 *3600;
    }
}