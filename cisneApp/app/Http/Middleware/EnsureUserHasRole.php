<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Debes iniciar sesión para acceder a esta área.');
        }

        if (!$request->user()->hasRole($role)) {
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta área.');
        }

        return $next($request);
    }
}
