<?php
// 应用公共文件

/**
 * 封装统一Api格式返回方法
 * @param $status,状态码 使用配置文件接管不能输入数字
 * @param string $msg 响应信息
 * @param array $data 返回数据
 * @param int $code 返回的http状态码
 * @return \think\response\Json
 */
function showJson($status, $msg = '', $data = [], $code = 200)
{
    $result = [
        "status" => config('status.'.$status)?? $status,
        "msg" => $msg,
        "data" => $data,
    ];
    return json($result,$code);
}
