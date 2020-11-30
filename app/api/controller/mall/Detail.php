<?php
namespace app\api\controller\mall;
use app\api\controller\ApiBase;
use app\common\business\Goods as GoodsBis;
use app\common\lib\ShowJson;

class Detail extends ApiBase
{
    public function index($id)
    {
        if(!$id){
            return  ShowJson::error();
        }
        $result = (new GoodsBis())->getGoodsDetailBySkuId($id);
        return ShowJson::success($result,'ok');
    }
}