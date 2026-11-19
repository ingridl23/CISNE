<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Las peticiones JSON reciben 401 en vez de una redirección
        if ($request->expectsJson()) {
            return null;
        }

        // El login es un modal en la home (no hay página de login aparte)
        return route('home');
    }
}
