<?php
declare (strict_types=1);

namespace app\admin\controller;

class Error
{
    public function __call($name, $arguments)
    {
        return showJson(400,"找不到{$name}控制器",null,404);
    }
}
