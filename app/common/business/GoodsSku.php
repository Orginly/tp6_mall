<?php
namespace app\common\business;
use app\common\model\mysql\GoodsSku as GoodsSkuModel;

class GoodsSku extends BusBase {
    public $model = NULL;

    public function __construct() {
        $this->model = new GoodsSkuModel();
    }

    /**
     * 批量新增逻辑
     */
    public function saveAll($data) {
        if (!$data['skus']) {
            return false;
        }

        foreach ($data['skus'] as $value) {
            $insertData[] = [
                "goods_id"        => $data['goods_id'],
                "specs_value_ids" => $value['propvalnames']['propvalids'],
                "price"           => $value['propvalnames']['skuSellPrice'],
                "cost_price"      => $value['propvalnames']['skuMarketPrice'],
                "stock"           => $value['propvalnames']['skuStock'],
            ];
        }

        //number_format round
        try {
            $result = $this->model->saveAll($insertData);
            return $result->toArray();
        } catch (\Exception $e) {
            // 记录日志
            return false;
        }
        return true;
    }

    public function getNormalSkuAndGoods($id) {
        try {
            $result = $this->model->with("goods")->find($id);
        } catch (\Exception $e) {
            return [];
        }
        if (!$result) {
            return [];
        }
        $result = $result->toArray();
        if ($result['status'] != config("status.mysql.table_normal")) {
            return [];
        }

        return $result;

    }

    public function getSkusByGoodsId($goodsId = 0) {
        if (!$goodsId) {
            return [];
        }
        try {
            $skus = $this->model->getNormalByGoodsId($goodsId);
        } catch (\Exception $e) {
            return [];
        }
        return $skus->toArray();
    }
    public function getNormalInIds($ids) {
        try {
            $result = $this->model->getNormalInIds($ids);
        } catch (\Exception $e) {
            return [];
        }
        return $result->toArray();
    }


    /**
     * 更新库存
     * @param $data
     * @return bool
     */
    public function updateStock($data) {
        // 这个地方 是有性能瓶颈
        // 10 sku_id stock  1 => 10 2= > 4  2 1  1 =>   9 3
        // 批量更新方式去处理
        foreach ($data as $value) {
            $this->model->incStock($value['id'], $value['num']);
        }
        return true;
    }

}