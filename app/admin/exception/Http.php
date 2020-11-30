<?php
namespace app\admin\exception;

use think\exception\Handle;
use think\Response;
use Throwable;

class Http extends Handle{
    public $httpStatus = 500;
    /**
     * 拦截不可遇知的异常处理
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        //判断是否已经存在状态码
        $statusCode = method_exists($e,'getStatusCode') ? $e->getStatusCode() : $this->httpStatus;
        return showJson('error',$e->getMessage(),null,$statusCode);
    }
}