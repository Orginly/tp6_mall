<?php


namespace app\common\lib;


class Arr
{
    /**
     * 组装数据 无限级分类
     * @param array $data
     * @return array
     */
    public static function getTree(array $data)
    {
        $items = [];
        //用id作为下标保存数据
        foreach ($data as $val) {
            //因为前端需要的id 名为category
            $val['category_id'] = $val['id'];
            unset($val['id']);
            $items[$val['category_id']] = $val;
        }
        $tree = [];
        foreach ($items as $id=>$val){
            //判断数组pid下标是否存在
            if(isset($items[$val['pid']])){
               $items[$val['pid']]['list'][] = &$items[$id];
            }else{
                $tree[] = &$items[$id];
            }
        }
        return $tree;
    }

    /**
     * 分页默认返回的数据
     * @param $num
     * @return array
     */
    public static function getPaginateDefaultData($num) {
        $result = [
            "total"        => 0,
            "per_page"     => $num,
            "current_page" => 1,
            "last_page"    => 0,
            "data"         => [],
        ];
        return $result;
    }

    public static function arrsSortByKey($result, $key, $sort = SORT_DESC) {
        if (!is_array($result) || !$key) {
            return [];
        }
        array_multisort(array_column($result, $key), $sort, $result);
        return $result;
    }
}