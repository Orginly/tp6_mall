<?php
use think\facade\Route;

//发送验证码
Route::rule('sendcode','sms/sendcode','POST');
//用户登录
Route::rule('login','login/index','POST');

//资源路由
Route::resource('user','User');

Route::rule("subcategory/:id", "category/sub");
Route::rule("detail/:id", "mall.detail/index");

Route::rule('lists','mall.lists/index');


Route::resource("order", "order.index");