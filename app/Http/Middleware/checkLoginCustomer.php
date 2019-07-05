<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Permission;

class checkLoginCustomer
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
        $result = Permission::checkLoginCustomer($request,['hash' => $request->route('hash')]);

        if($result !== true){
            return $result;
        }
        else{
            return $next($request);
        }
    }
}
