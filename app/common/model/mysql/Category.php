<?php
declare(strict_types=1);

namespace app\common\model\mysql;
class Category extends \think\Model
{
    protected $autoWriteTimestamp = true;

    public function getCategoryALL()
    {
        return $this->where('status',config('status.mysql.table_normal'))->select();
    }

    /**
     * 通过id查找分类
     * @param int $id
     * @return array|bool|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategoryById(int $id)
    {
        if (!$id) {
            return false;
        }
        return $this->where('id', $id)->find();
    }


    /**
     * 通过name查找分类
     * @param string $name
     * @return array|bool|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategoryByName(string $name)
    {
        if (!$name) {
            return false;
        }
        return $this->where('name', $name)->find();
    }

    /**
     * 通过pid查找分类并分页 如果$pageSize则不返回分页格式
     * @param int $pid
     * @param int $pageSize
     * @return \think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategoryAllByPid(int $pid = 0, int $pageSize = 10)
    {
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        if($pageSize == 0){
            return $this->where('pid',$pid)->where('status','<>',config('status.mysql.table_delete'))->order($order)->select();
        }
        return $this->where('pid', $pid)->where('status','<>',config('status.mysql.table_delete'))->order($order)->paginate($pageSize);
    }

    /**
     * 通过id更新分类数据
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateCategoryById(int $id, array $data)
    {
        if (!$id || !$data) {
            return false;
        }
        $res = $this->where('id',$id)->save($data);
        if(!$res){
            return false;
        }
        return true;
    }
}