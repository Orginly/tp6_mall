<?php

namespace app\common\lib;
class Key {

    /**
     * userCart 记录用户购物车的redis key
     * @param $userId
     * @return string
     */
    public static function userCart($userId) {
        return config("redis.cart_pre") . $userId;
    }
}