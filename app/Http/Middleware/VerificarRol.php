<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerificarRol
{
    public function handle($request, Closure $next, $rol)
    {
        // $user = Auth::user();
        $user = Auth::guard('usuarios')->user();

       if (!$user || ($user->rol !== $rol && $user->rol !== 'superadministrador')) {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
}