<?php

namespace app\admin\middleware;

class AuthLogin
{
    public function handle($request, \Closure $next)
    {
        //前置中间件
        $admin_session = session(config('admin.session_admin'));
        if(preg_match('/verify/',$request->pathinfo())){
            return $next($request);
        }
        //如果session为空且不在登录页面
        if(!$admin_session && !preg_match('/login/',$request->pathinfo())){
            return redirect(url('login/index'));
        }
        //下一步请求
        $response =  $next($request);
        //后置中间件
        return $response;
    }

    /**
     * 中间件结束条度
     * @param \think\Response $response
     */
    public function end(\think\Response $response)
    {

    }
}