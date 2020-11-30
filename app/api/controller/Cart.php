<?php
namespace app\api\controller;
use app\common\business\GoodsSku;
use app\common\lib\ShowJson;
use think\facade\Cache;

class Cart extends AuthBase
{
    public function add()
    {
        if(!$this->request->isPost()){
            return ShowJson::error('请求方式错误');
        }
        $id = $this->request->post('id','','intval');
        $num = $this->request->post('num','','intval');
        if(!$id||!$num){
            return ShowJson::error('参数不合法');
        }
        $res = (new \app\common\business\Cart())->insertRedis($this->userId,$id,$num);
        if($res === FALSE){
            return ShowJson::error('添加购物车失败');
        }
        return ShowJson::success([],'添加购物车成功');
    }

    /**
     * 购物车列表
     * @param string $ids
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function lists()
    {
        $ids = request()->get('id','','trim');
        $lists = (new \app\common\business\Cart())->lists($this->userId,$ids);
        return ShowJson::success($lists,'ok');
    }

    public function delete()
    {
        $id = request()->post('id','','intval');
        if(!$id){
            return ShowJson::error('参数错误');
        }
        $res = (new \app\common\business\Cart())->deleteRedis($this->userId,$id);
        if(!$res){
            return ShowJson::error('删除失败');
        }
        return ShowJson::success([],'移除成功');
    }

    public function update()
    {
        $id = request()->post('id','','intval');
        $num = request()->post('num','','intval');
        $res = (new \app\common\business\Cart())->updateRedis($this->userId,$id,$num);
        if(!$res){
            return ShowJson::error('更新商品失败');
        }
        return  ShowJson::success([],'ok');
    }
}