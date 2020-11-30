<?php
namespace app\admin\controller;
use think\captcha\facade\Captcha;
class Verify {
    protected $middleware = [];
    public function index()
    {
        return Captcha::create('verify');
    }
}