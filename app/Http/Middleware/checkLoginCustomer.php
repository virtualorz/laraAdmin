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

        /*
        if(session('js_promote_customer') == null && session('js_promote') == null)
        {
            session(['return_url'=> $request->fullUrl()]);

            return redirect()->route('login',['hash' => $request->route('hash')]);
        }
        return $next($request);
        */
    }
}
