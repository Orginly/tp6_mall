<?php


namespace app\api\controller;


use app\common\lib\Arr;

class Category extends ApiBase
{
    public function index()
    {
        $category = (new \app\common\business\Category())->getCategoryList();
        $tree = Arr::getTree($category->toArray());
        return $this->showJson('success','ok',$tree);
//                return $this->showJson('success','ok',$category->toArray());
    }
    /**
     * api/category/search/51
     * 商品列表页面中 按栏目检索的内容
     * @return \think\response\Json
     */
    public function search() {
        //TODO 获取分类名称待做
        $result = [
            "name"      => "我是一级分类",
            "focus_ids" => [1, 11],
            "list"      => [
                [
                    ["id" => 1, "name" => "二级分类1"],
                    ["id" => 2, "name" => "二级分类2"],
                    ["id" => 3, "name" => "二级分类3"],
                    ["id" => 4, "name" => "二级分类4"],
                    ["id" => 5, "name" => "二级分类5"],
                ],

                [
                    ["id" => 11, "name" => "三级分类1"],
                    ["id" => 12, "name" => "三级分类2"],
                    ["id" => 13, "name" => "三级分类3"],
                    ["id" => 14, "name" => "三级分类4"],
                    ["id" => 15, "name" => "三级分类5"],
                ],
            ],
        ];

        return showJson('success', "ok", $result);
    }

    /**
     * 获取子分类  category/sub/2
     * @return \think\response\Json
     */
    public function sub() {
        $result = [
            ["id" => 21, "name" => "点二到三分类1"],
            ["id" => 22, "name" => "点二级三分类2"],
            ["id" => 33, "name" => "点二到三分类3"],
            ["id" => 134, "name" => "点二到三分类4"],
            ["id" => 154, "name" => "点二到三分类5"],
        ];
        return showJson('success', "ok", $result);
    }
}