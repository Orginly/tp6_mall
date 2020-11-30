<?php

namespace app\admin\validate;

class Category extends \think\Validate
{
    protected $rule = [
        'name' => 'require',
        'pid' => 'require|number',

    ];
    protected $message = [
        'name.require' => '分类名称不得为空',
        'pid' => '上级分类不得为空'
    ];
}