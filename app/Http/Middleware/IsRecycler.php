<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsRecycler
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
        if (Auth::user() && (Auth::user()->is_admin == 4 || Auth::user()->is_admin == 1)) {
            return $next($request);
        }
        if (Auth::user() && Auth::user()->is_admin == 2) {
            return redirect('/profesor');
        }
        if (Auth::user() && Auth::user()->is_admin == 3) {
            return redirect('/horario');
        }
        if (Auth::user() && Auth::user()->is_admin == 4) {
            return redirect('/residuos');
        }   
        return redirect('/login');
    }
}