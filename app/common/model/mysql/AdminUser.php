<?php
namespace app\common\model\mysql;
use think\Model;

class AdminUser extends Model{
    /*
     * 通过用户名获取用户数据
     */
    public function getByUsername($username)
    {
        if(empty($username)){
            return false;
        }
        return $this->where('username',$username)->find();
    }

    /**
     * 根据主键id更新数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id,$data)
    {
        $id = intval($id);
        if(empty($id) || empty($data) || !is_array($data)){
            return false;
        }
        return $this->where('id',$id)->save($data);
    }
}