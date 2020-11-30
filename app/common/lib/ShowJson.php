<?php

namespace app\common\lib;
class ShowJson
{
    /**
     * Api返回JSON信息成功
     * @param array $data
     * @param string $msg
     * @return \think\response\Json
     */
    public static function success($data = [], $msg = '')
    {
        $result = [
            'status' => config('status.success'),
            'msg' => $msg,
            'data' => $data
        ];
        return json($result);
    }

    /**
     * Api返回JSON信息 失败
     * @param string $msg
     * @param int $status 业务状态码
     * @return \think\response\Json
     */
    public static function error($msg = '',$status = 0)
    {
        $result = [
            'status' => $status,
            'msg' => $msg,
            'data' => []
        ];
        return json($result);
    }
}