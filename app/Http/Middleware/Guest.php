<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class Guest
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
        if(!Auth::user()){
            if(!session('guest')){
                session()->put('guest',date('dymhis'.rand(111,999)));
            }
        }else{
            session()->put('guest', Auth::user()->id);
        }
        return $next($request);
    }
}
