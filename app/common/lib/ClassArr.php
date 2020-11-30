<?php
declare(strict_types=1);
namespace app\common\lib;
/**
 * 工厂模式类库
 * Class ClassArr
 * @package app\common\lib
 */
class ClassArr
{
    /**
     * 短信服务的基础类
     * @return array|string[]
     */
    public static function smsClassStat(): array
    {
        return [
            'ali' => 'app\common\lib\sms\AliSms',
            'baidu' => 'app\common\lib\sms\baiduSms',
            'jd' => 'app\common\lib\sms\jdSms',
        ];
    }

    /**
     * 反射机制处理 工厂模式
     * @param string $type 相当于$classs的key值 ali baidu js
     * @param array $classs 基础类库 存放着类的命名空间
     * @param array $param 实例化class类需要传的参数
     * @param bool $needInstance 是否需要实例化类
     * @return bool|mixed|object
     * @throws \ReflectionException
     */
    public static function initClass(string $type, array $classs, array $param = [], bool $needInstance = false)
    {
        //如果工厂模式调用的是静态方法就返回类库 比如 'AliSms'
        //如果不是静态方法就返回一个对象
        if (!array_key_exists($type, $classs)) {
            return false;
        }
        $className = $classs[$type];

        //如果需要实例化就使用反射类实例化类，不需要则返回 app\common\lib\sms\AliSms
        // new ReflectionClass('A') =>建立A反射类
        //->newInstanceArgs($args)=>相当于实例化A对象
        return $needInstance ? (new \ReflectionClass($className))->newInstanceArgs($param) : $className;

    }
}