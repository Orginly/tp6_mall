<?php

namespace app\api\controller;
class Error
{
    public function __call($name, $arguments)
    {
        return showJson(400,"找不到{$name}控制器",null,404);
    }
}