<?php

namespace app\common\business;

use app\common\model\mysql\SpecsValue as SpecsValueModel;

class SpecsValue extends BusBase
{
    public $model = NULL;

    public function __construct()
    {
        $this->model = new SpecsValueModel();
    }

    /**
     * getBySpecsId
     * @param $specsId
     * @return array
     */
    public function getBySpecsId($specsId)
    {
        try {
            $result = $this->model->getNormalBySpecsId($specsId, "id,name");
        } catch (\Exception $e) {
            return [];
        }
        $result = $result->toArray();
        return $result;
    }

    public function dealGoodsSkus($gids, $flagValue)
    {
        $specsValueKeys = array_keys($gids);
        foreach ($specsValueKeys as $specsValueKey) {
            $specsValueKey = explode(",", $specsValueKey);
            foreach ($specsValueKey as $k => $v) {
                $new[$k][] = $v;
                $specsValueIds[] = $v;
            }
        }
        $specsValueIds = array_unique($specsValueIds);

        $specsValues = $this->getNormalInIds($specsValueIds);
        $flagValue = explode(",", $flagValue);
        $result = [];
        foreach ($new as $key => $newValue) {
            $newValue = array_unique($newValue);
            $list = [];
            foreach ($newValue as $vv) {
                $list[] = [
                    "id" => $vv,
                    "name" => $specsValues[$vv]['name'],
                    "flag" => in_array($vv, $flagValue) ? 1 : 0,
                ];
            }

            $result[$key] = [
                "name" => $specsValues[$newValue[0]]['specs_name'],
                "list" => $list,
            ];

        }
        return $result;

    }

    public function getNormalInIds($ids)
    {
        if (!$ids) {
            return [];
        }

        try {
            $result = $this->model->getNormalInIds($ids);
        } catch (\Exception $e) {
            return [];
        }
        $result = $result->toArray();
        if (!$result) {
            return [];
        }

        $specsNames = config("specs");
        $specsNamesArrs = array_column($specsNames, "name", "id");

        $res = [];
        foreach ($result as $resultValue) {
            $res[$resultValue['id']] = [
                'name' => $resultValue['name'],
                'specs_name' => $specsNamesArrs[$resultValue['specs_id']] ?? "",
            ];
        }

        return $res;

    }

    public function dealSpecsValue($skuIdSpecsValueIds)
    {
        $ids = array_values($skuIdSpecsValueIds);
        // 如果是多sku组合 使用下面的
        $ids = implode(",", $ids);
        $ids = array_unique(explode(",", $ids));

        // 如果是单sku的用下面的 ,  整体来说直接用上面的即可
        /////$ids = array_unique($ids);

        $result = $this->getNormalInIds($ids);
        if (!$result) {
            return [];
        }

        $res = [];
        foreach ($skuIdSpecsValueIds as $skuId => $specs) {
            // 1, 7
            $specs = explode(",", $specs);
            //$specs  [1,7]
            // 处理sku默认文案
            $skuStr = [];
            foreach ($specs as $spec) {
                $skuStr[] = $result[$spec]['specs_name'] . ":" . $result[$spec]['name'];
            }
            $res[$skuId] = implode("  ", $skuStr);
        }
        return $res;
    }
}