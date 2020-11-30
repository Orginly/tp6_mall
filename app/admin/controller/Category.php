<?php

namespace app\admin\controller;
use app\BaseController;
use think\Exception;
use think\exception\ValidateException;
use think\Request;

class Category extends BaseController
{
    public function index()
    {
        $pid = request()->get('pid', 0, 'intval');
        try {
            $category = (new \app\common\business\Category())->getCategoryByPid($pid, 10);
        } catch (\Exception $e) {
            $category = [];
        }
        return view('', ['category' => $category]);
    }

    public function add()
    {
        return view();
    }

    /**
     * 获取所有分类信息
     * @return \think\response\Json
     * @throws Exception
     */
    public function getCategoryList()
    {
        $data = (new \app\common\business\Category())->getCategoryList();
        return showJson('success', '获取成功', $data);
    }

    /**
     * 添加分类
     * @return \think\response\Json
     */
    public function save()
    {
        if (!request()->isPost()) {
            return showJson('error', '请求方式错误');
        }
        $name = request()->post('name', '', 'trim');
        $pid = request()->post('parent', '', 'intval');
        $data = [
            'name' => $name,
            'pid' => $pid
        ];
        try {
            validate(\app\admin\validate\Category::class)->check($data);
        } catch (ValidateException $e) {
            return showJson('error', $e->getMessage());
        }
        //调用业务层数据
        try {
            (new \app\common\business\Category())->saveCategory($data);
        } catch (Exception $e) {
            return showJson('error', $e->getMessage());
        }
        return showJson('success', '添加分类成功');
    }

    /**
     * 服务器排序字段
     * @param Request $request
     * @return \think\response\Json
     * @throws Exception
     */
    public function listorder(Request $request)
    {
        $id = $request->get('id', '', 'intval');
        $listorder = $request->get('listorder', '', 'intval');
        if (!$id || !$listorder) {
            return showJson('success', '参数错误');
        }
        $result = (new \app\common\business\Category())->updateCategoryOrder($id, $listorder);
        if (!$result) {
            return showJson('error', '更新排序失败');
        }
        return showJson('success', '更新排序成功');
    }

    /**
     * 假删除数据
     * @return \think\response\Json
     * @throws Exception
     */
    public function categoryDel()
    {
        if(!request()->isGet()){
            return showJson('error', '请求错误');
        }
        $id = request()->get('id','','intval');
        $result = (new \app\common\business\Category())->categoryDel($id);
        if (!$result) {
            return showJson('error', '删除失败');
        }
        return showJson('success', '删除成功');
    }

    /**
     *
     * @return \think\response\View
     * @throws Exception
     */
    public function dialog()
    {
        //获取一级分类数据
        $categorys = (new \app\common\business\Category())->getCategoryByPid(0);
        $data = [
            'categorys' => json_encode($categorys->toArray())
        ];

        return view('',$data);
    }

    public function getCategoryByPid()
    {
        $pid = request()->get('pid','','intval');
        if(empty($pid)){
            return showJson('error','参数错误');
        }
        $categorys = (new \app\common\business\Category())->getCategoryByPid($pid);
        return showJson('success','ok',$categorys);
    }
}