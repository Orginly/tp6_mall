<?php


namespace app\common\model\mysql;

use think\Model;

class Order extends Model
{
    protected $autoWriteTimestamp = true;

    public function getByCondition($condition, $order = ['id' => 'desc'])
    {
        if (!$condition || !is_array($condition)) {
            return false;
        }

        return $this->where($condition)
            ->order($order)
            ->select();
    }
}