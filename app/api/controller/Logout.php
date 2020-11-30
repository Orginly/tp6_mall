<?php
namespace app\api\controller;

class Logout extends AuthBase
{
    public function index()
    {
        $res = cache(config('redis.token_pre').$this->token,null);
        if(!$res){
           return $this->showJson('error','退出登录失败');
        }
        return $this->showJson('success','退出登录成功');
    }
}