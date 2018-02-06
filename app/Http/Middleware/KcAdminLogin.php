<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Libs\Tool;

class KcAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {

            $tool = new Tool();

            //后台
            if($guard == 'admin'){
                if($request->ajax() || $request->wantsJson()){
                    return $tool->setStatusCode('401')->reponseErroe();
                }
                return redirect('/login');
            }
            //前台
            return redirect('/login');
        }

        return $next($request);
    }
}
