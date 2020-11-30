<?php
/**
 * 存放业务状态码相关的配置
 */
return [
    "success" => 200,//成功
    "not_found"=>404,
    "error" => 400,
    "not_login" => -1,//未登录
    "user_is_register" => -2,//用户已注册

    "mysql" => [
        //用户状态
        "user_disable" => 0,//禁用
        "table_normal" => 1,//启用
        "table_pending" => 2,//待审核
        "table_delete" => 99,//已删除
    ]
];