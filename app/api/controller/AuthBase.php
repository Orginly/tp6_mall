<?php
declare(strict_types=1);
namespace app\api\controller;
/**
 * 如果需要登录场景那他需要继承AuthBae
 * Class AuthBase
 * @package app\api\controller
 */
class AuthBase extends ApiBase
{
    public $token = '';
    public $username = '';
    public $userId = '';
    public function initialize()
    {
        parent::initialize();
        //获取header token
        $accessToken = $this->token = $this->request->header('access-token');
        if(!$accessToken || !$this->isLogin()){
            return $this->showJson(config('status.not_login'),'未授权');
        }
    }


    /**
     * 判断用户是否登录
     * @return bool
     */
    public function isLogin():bool
    {
        $userInfo = cache(config('redis.token_pre').$this->token);
        if(!$userInfo['username'] && !$userInfo['id']){
            return false;
        }
        $this->userId = $userInfo['id'];
        $this->username = $userInfo['username'];
        return  true;
    }
}