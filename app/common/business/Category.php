<?php
declare(strict_types=1);

namespace app\common\business;

use think\Exception;
use think\facade\Log;
use think\helper\Arr;

class Category
{
    protected $CategoryModel = null;

    public function __construct()
    {
        $this->CategoryModel = new \app\common\model\mysql\Category();
    }

    /**
     * 添加分类
     * @param array $data
     * @return bool
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function saveCategory(array $data)
    {
        if (!$data) {
            return false;
        }
        //判断分类名是否重复
        $category = $this->CategoryModel->getCategoryByName($data['name']);
        if ($category) {
            throw new Exception('分类已经存在！');
        }
        //判断上级id是否存在
        if ($data['pid'] != 0) {
            $category = $this->CategoryModel->getCategoryById($data['pid']);
            if (!$category) {
                throw new Exception('上级分类不存在');
            }
        }
        $data['status'] = config('status.mysql.table_normal');
        //添加数据
        try {
            $this->CategoryModel->save($data);
        } catch (\Exception $e) {
            Log::info("Category-save-Category-" . json_encode($data) . '-' . $e->getMessage());
            throw new Exception('数据库内部异常');
        }
        //返回最后增加记录的id
        return $this->CategoryModel->getLastInsID();
    }

    /**
     * 获取全部分类数据
     * @return \think\Collection
     * @throws Exception
     */
    public function getCategoryList()
    {
        try {
            $categoryList = $this->CategoryModel->getCategoryALL();
        }catch(Exception $e){
            Log::info("Category-getCategoryList-".$e->getMessage());
            throw new Exception('数据库内部错误');
        }
        return $categoryList;
    }

    /**
     * 获取pid下的所有分类
     * @param int $id 传入pid
     * @param int $pageSize
     * @return bool|\think\Paginator
     * @throws Exception
     */
    public function getCategoryByPid(int $id,int $pageSize = 0)
    {

        try {
            if($pageSize == 0){
                $categoryList = $this->CategoryModel->getCategoryAllByPid($id,0);
            }else{
                $categoryList = $this->CategoryModel->getCategoryAllByPid($id,$pageSize);
            }
        }catch(Exception $e){
            Log::info("Category-getCategoryList-".$e->getMessage());
            throw new Exception('数据库内部错误');
        }
        return $categoryList;
    }

    /**
     * 通过if更新用户数据
     * @param int $id
     * @param int $listorder
     * @return bool
     * @throws Exception
     */
    public function updateCategoryOrder(int $id,int $listorder)
    {
        $data = [
            'listorder' => $listorder
        ];
        try {
            $result = $this->CategoryModel->updateCategoryById($id,$data);
        }catch(Exception $e){
            throw new Exception('数据库内部错误');
        }
        return $result;
    }

    /**
     * 假删除数据 更新状态为99
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function categoryDel(int $id)
    {
        $data = [
            'status' => 99
        ];
        try {
            $result = $this->CategoryModel->updateCategoryById($id,$data);
        }catch(Exception $e){
            throw new Exception('数据库内部错误');
        }
        return $result;
    }
}