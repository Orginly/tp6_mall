<?php

namespace app\api\exception;

use think\Exception;
use think\exception\Handle;
use think\exception\HttpResponseException;
use think\Response;
use Throwable;

class Http extends Handle
{
    public $httpStatus = 500;

    /**
     * 拦截异常处理
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        //捕获通过 throw new Exception('msg') 抛出的异常
        //如果e对象属于Exception类 也是是通过 new Exception('msg')抛出的异常
        if ($e instanceof Exception) {
            return showJson($e->getCode(), $e->getMessage());
        }
        //捕获抛出的HTTP响应异常
        if ($e instanceof HttpResponseException) {
            return parent::render($request, $e);
        }
        // 添加自定义异常处理机制
        //判断是否已经存在状态码
        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : $this->httpStatus;
        return showJson('error', $e->getMessage(), [], $statusCode);
    }
}