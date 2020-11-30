<?php


namespace app\common\model\mysql;


use think\Model;

class OrderGoods extends Model
{
    protected $autoWriteTimestamp = true;

    public function getByOrderId($orderId)
    {
        try {
            return $this->where('order_id',$orderId)->select();
        }catch(\Exception $e){
            return false;
        }
    }
}