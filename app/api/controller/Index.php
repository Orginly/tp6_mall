<?php
namespace app\api\controller;
use app\BaseController;
use app\common\business\Goods as GoodsBis;
use app\common\lib\ShowJson;

class Index extends BaseController {

    public function getRotationChart() {
        $result = (new GoodsBis())->getRotationChart();
        return ShowJson::success($result);
    }

    public function cagegoryGoodsRecommend() {
        //TODO 动态获取栏目
        $categoryIds = [
            4,
            1];
        $result = (new GoodsBis())->cagegoryGoodsRecommend($categoryIds);
        return ShowJson::success($result);
    }

}