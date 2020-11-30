<?php
namespace app\api\controller\mall;
use app\api\controller\AuthBase;
use app\common\business\Cart;
use app\common\lib\ShowJson;

class Init extends AuthBase
{
    public function index()
    {
        $result = (new Cart())->getCount($this->userId);
        return ShowJson::success($result);
    }
}