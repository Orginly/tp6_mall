<?php
namespace app\common\business;
use app\common\lib\Arr;
use app\common\lib\Key;
use think\Cache;
use think\cache\driver\Redis;

class Cart
{
    public function insertRedis($userId,$id,$num)
    {
        $goodsSku = (new GoodsSku())->getNormalSkuAndGoods($id);
        if(!$goodsSku){
            return false;
        }
        $data = [
            "title" => $goodsSku['goods']['title'],
            "image" => $goodsSku['goods']['recommend_image'],
            "num" => $num,
            "goods_id" => $goodsSku['goods']['id'],
            "create_time" => time(),
        ];
        try {
            $redis = new Redis();
            $get = $redis->hGet(config('redis.cart_pre').$userId,$id);
            if($get){
                $get = json_decode($get,true);
                $data['num'] += $get['num'];
            }
            //参一、哈希名，哈希key，哈希内容
            $redis->hSet(config('redis.cart_pre').$userId,$id,json_encode($data));
        }catch(\Exception $e){
            return false;
        }
    }

    public function lists($userId, $ids) {
        $redis = new Redis();
        try {
            if($ids) {
                $ids = explode(",", $ids);
                $res = $redis->hMget(Key::userCart($userId), $ids);
                if(in_array(false, array_values($res))) {
                    return [];
                }
            } else {
                $res = $redis->hGetAll(Key::userCart($userId));
            }
        }catch (\Exception $e) {
            $res = [];
        }
        if(!$res) {
            return [];
        }

        $result = [];
        $skuIds = array_keys($res);
        $skus = (new GoodsSku())->getNormalInIds($skuIds);

        $stocks = array_column($skus, "stock", "id");
        $skuIdPrice = array_column($skus, "price", "id");
        $skuIdSpecsValueIds = array_column($skus, "specs_value_ids", "id");
        $specsValues = (new SpecsValue())->dealSpecsValue($skuIdSpecsValueIds);

        foreach($res as $k => $v) {
            $price = $skuIdPrice[$k] ?? 0;
            $v = json_decode($v, true);
            if($ids && isset($stocks[$k]) && $stocks[$k] < $v['num']) {
                throw new \think\Exception($v['title']."的商品库存不足");
            }
            $v['id'] = $k;
            $v['image'] = preg_match("/http:\/\//", $v['image']) ? $v['image'] : request()->domain().$v['image'];
            $v['price'] = $price;
            $v['total_price'] = $price * $v['num'];
            $v['sku'] = $specsValues[$k] ?? "暂无规则";
            $result[] = $v;
        }
        if(!empty($result)) {
            $result = Arr::arrsSortByKey($result, "create_time");
        }
        return $result;
    }

    /**
     * 删除购物车功能
     * @param $userId
     * @param $id
     * @return bool
     */
    public function deleteRedis($userId, $ids) {
        if(!is_array($ids)) {
            $ids = explode(",", $ids); // id=1  => [1]  ,  1,2 => [1, 2, 5,6]
        }
        try {
            $redis = new Redis();
            // ... 是PHP提供一个特性 可变参数
            $res = $redis->hDel(Key::userCart($userId), ...$ids);
        }catch (\Exception $e) {
            return FALSE;
        }
        return $res;

        // 小伙伴请注意： 预留作业： 删除所有的购物车内容
    }


    /**
     * 更新购物车中的商品数量
     * @param $userId
     * @param $id
     * @param $num
     * @return bool
     * @throws \think\Exception
     */
    public function updateRedis($userId,  $id, $num) {
        $redis = new Redis();
        try {
            $get = $redis->hGet(Key::userCart($userId), $id);
        }catch (\Exception $e) {
            return FALSE;
        }
        if($get) {
            $get = json_decode($get, true);
            $get['num'] = $num;
        } else {
            throw new \think\Exception("不存在该购物车的商品，您更新没有任何意义");
        }
        try {
            $redis->hSet(Key::userCart($userId), $id, json_encode($get));
        }catch (\Exception $e) {

            return FALSE;
        }
        return true;
    }

    /**
     * 获取购物车数据
     * @param $userId
     * @return int
     */
    public function getCount($userId) {
        $redis = new Redis();
        try {
            $count = $redis->hLen(Key::userCart($userId));
        }catch (\Exception $e) {
            return 0;
        }
        return intval($count);
    }
}