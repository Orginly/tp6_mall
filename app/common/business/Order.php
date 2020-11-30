<?php

namespace app\common\business;

use app\common\lib\Snowflake;
use think\Exception;
use app\common\model\mysql\OrderGoods;

class Order extends BusBase
{
    protected $model = null;

    public function __construct()
    {
        $this->model = new \app\common\model\mysql\Order();
    }

    public function detail($data)
    {
        $condition = [
            'user_id' => $data['user_id'],
            'order_id' => $data['order_id']
        ];
        try {
            $order = $this->model->getByCondition($condition);
            $order = $order ? $order[0] : [];
            //TODO 获取地址信息
            $order['id'] = $order['order_id'];
            $order['consignee_info'] = '广西 南宁市 江南区';
            $order['mall_title'] = '111';
            $order['price'] = $order['total_price'];
            //查询商品信息
            $orderGoods = (new OrderGoods())->getByOrderId($order['order_id']);
            if(!$orderGoods){
                return false;
            }
            $order['malls'] = $orderGoods->toArray();
            return $order;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * 保存订单数据
     * @param $data
     * @return bool|int
     * @throws Exception
     */
    public function save($data)
    {
        //获取雪花id
        $workId = rand(1, 1023);
        $orderId = (string)Snowflake::getInstance()->setWorkId($workId)->id();

        //获取购物车数据
        $cartObj = new Cart();
        $cart = $cartObj->lists($data['user_id'], $data['ids']);
        if (!$cart) {
            return false;
        }
        $newCart = array_map(function ($item) use ($orderId) {
            $item['sku_id'] = $item['id'];
            unset($item['id']);
            $item['order_id'] = $orderId;
            return $item;
        }, $cart);
        //获取到指定字段的数据 获取总价格数
        $priceArr = array_column($cart, 'total_price');
        $price = array_sum($priceArr);
        $orderData = [
            'user_id' => $data['user_id'],
            'order_id' => $orderId,
            'total_price' => $price,
            'address_id' => $data['address_id']
        ];


        //开启事务
        $this->model->startTrans();
        try {
            //新增order
            $order = $this->add($orderData);
            if (!$order) {
                return false;
            }
            //新增order goods
            $orderGoods = (new OrderGoods())->saveAll($newCart);
            if (!$orderGoods) {
                throw new Exception('新增商品副表失败');
            }
            // goods_sku库存更新
            $goodsSku = (new GoodsSku())->updateStock($cart);
            if (!$goodsSku) {
                throw new Exception('更新商品库存失败');
            }
            //TODO goods更新商品总库存
            if (!$goodsSku) {
                return false;
            }
            //删除购物车里面的商品
            //提交事务
            $this->model->commit();
            return $orderId;
        } catch (\Exception $e) {
            echo $e->getMessage();
            //事务回滚
            $this->model->rollback();
            return false;
        }

    }

}