<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Mod
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
        if(!Auth::check()){
            return redirect()->route('home');
        }

        if(Auth::user()->isAdmin != 2 && Auth::user()->isMod != 2){
            return redirect()->route('home');
        }

        return $next($request);
    }
}
