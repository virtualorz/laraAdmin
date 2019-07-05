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
    }
}
