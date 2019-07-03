<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Permission;

class checkPermission
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
        $result = Permission::checkPermission();

        if($result){
            return $next($request);
        }

        /*
        $checkPermission = Route::currentRouteName();
        if(!isset(Route::current()->action['name'])){
            $checkPermission = Route::current()->action['parent'];
        }
        if(!in_array($checkPermission,session('js_promote.permission'))){
            //abort(403, '沒有使用權限');
        }
        return $next($request);
        */
    }
}
