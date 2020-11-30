<?php
namespace app\api\controller\order;
use app\common\business\Order;
use app\common\lib\ShowJson;
use think\Exception;
use app\common\business\Order as OrderBis;
class Index extends \app\api\controller\AuthBase
{

    public function read($id)
    {
        if(!$id){
            return ShowJson::error('订单不存在');
        }
        $data = [
            'user_id' => $this->userId,
            'order_id' => $id,
        ];
        $result = (new Order())->detiail($data);
        if(!$result){
            return ShowJson::error('获取订单失败');
        }
        return ShowJson::success($result,'ok');
    }

    /**
     * 新增订单方法
     * @return \think\response\Json
     */
    public function save()
    {
        $addressId = request()->post('addressId', 1, 'intval');
        $ids = request()->post('ids', 0, 'trim');
        if (!$addressId || !$ids) {
            return ShowJson::error('参数错误');
        }
        $data = [
            'ids' => $ids,
            'address_id' => $addressId,
            'user_id' => $this->userId,
        ];
        try {
            $result = (new OrderBis())->save($data);
        }catch(Exception $e){
            return ShowJson::error($e->getMessage());
        }
        if(!$result){
            return ShowJson::error('提交订失败请重试');
        }
        return ShowJson::success($result,'ok');
    }
}