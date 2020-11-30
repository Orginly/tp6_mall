<?php
namespace app\admin\controller;
use app\BaseController;
use app\common\business\Goods as GoodsBis;

class Goods extends BaseController {
    public function index() {
        $data  = [];
        $title = input("param.title", "", "trim");
        $time  = input("param.time", "", "trim");

        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($time)) {
            $data['create_time'] = explode(" - ", $time);
        }
        $goods = (new GoodsBis())->getLists($data, 5);
        return view("", [
            "goods" => $goods,
        ]);
    }

    public function add() {
        return view();
    }

    /**
     * 新增逻辑
     * @return \think\response\Json
     */
    public function save() {
        if (!$this->request->isPost()) {
            return showJson('error', "参数不合法");
        }
        // Todo：validate验证机制验证参数,
        $data  = input("param.");
        $check = $this->request->checkToken('__token__');
        if (!$check) {
            return showJson('error', "非法请求");
        }
        // 数据处理 = > 基于 我们得验证成功之后
        $data['category_path_id'] = $data['category_id'];
        $result                   = explode(",", $data['category_path_id']);
        $data['category_id']      = end($result);
        $res = (new GoodsBis())->insertData($data);
        if (!$res) {
            return showJson('error', "商品新增失败");
        }

        return showJson('success', "商品新增成功");
    }
}