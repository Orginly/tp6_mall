<?php
namespace app\admin\controller;
use app\BaseController;
use app\common\business\SpecsValue as SpecsValueBis;
class SpecsValue extends BaseController {
    /**
     * 新增逻辑
     */
    public function save() {
        $specsId = input("param.specs_id", 0, "intval");
        $name = input("param.name", "", "trim");

        $data = [
            "specs_id" => $specsId,
            "name" => $name,
        ];
        $id = (new SpecsValueBis())->add($data);
        if(!$id) {
            return showJson('error', "新增失败");
        }

        return showJson(config("status.success"), "OK", ["id" => $id]);
    }

    public function getBySpecsId() {
        $specsId = input("param.specs_id", 0, "intval");
        if(!$specsId) {
            return showJson('success', "没有数据哦");
        }

        $result = (new SpecsValueBis())->getBySpecsId($specsId);
        return showJson('success', "OK", $result);
    }
}