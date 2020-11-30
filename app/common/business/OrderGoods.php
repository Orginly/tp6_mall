<?php

namespace app\common\business;
class OrderGoods extends BusBase
{
    protected $model = null;
    public function __construct()
    {
        $this->model = new \app\common\model\mysql\OrderGoods();
    }

    /**
     * 保存数据
     * @param $data
     * @return bool|\think\Collection
     */
    public function saveAll($data)
    {
        try {
            return $this->model->saveAll($data);

        }catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }




}