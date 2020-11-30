<?php
//declare(strict_types=1);
namespace app\common\model\mysql;

use think\Model;

class User extends Model
{
    //开启自动写如时间 字段必须是 create_time 和 update_time
    protected $autoWriteTimestamp = true;

    /**
     * 通过id获取用户数据
     * @param int $id
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserById(int $id)
    {
        if(!$id){
            return false;
        }
        return $this->find($id);
    }
    /**
     * 通过手机号获取用户数据
     * @param string $phone
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByPhone(string $phone)
    {
        if (!$phone) {
            return false;
        }
        return $this->where('phone', $phone)->find();
    }

    /**
     * 根据用户名获取用户数据
     * @param string $username
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByUsername(string $username)
    {
        if (!$username) {
            return false;
        }
        return $this->where('username', $username)->find();
    }

    /**
     * 通过id更新用户数据
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateById(int $id,array $data)
    {
        if(!$id||!$data){
            return false;
        }
        return $this->where('id',$id)->save($data);
    }
}