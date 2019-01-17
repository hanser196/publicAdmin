<?php

namespace App\Http\Middleware;

use Closure;

class Admin_id
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //验证用户是否已开启
        if($request->session()->exists('admin_id')){
            return $next($request);
        }else{
            return redirect('/admin/login')->with('error', '请您先进行登录认证');
        }
    }
}
