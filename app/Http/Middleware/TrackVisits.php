<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visita;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    /**
     * Por qué va en el middleware (y no en otro lado)

✔️ Se ejecuta en cada request automáticamente
✔️ No dependés de acordarte de llamarlo
✔️ No contás visitas del panel admin
✔️ No contás POST / PUT / DELETE
✔️ Código centralizado y limpio
     */
    public function handle(Request $request, Closure $next)
    {
        // IMPORTANTE: primero continuar la request
        $response = $next($request);

        // Luego registrar la visita (solo páginas públicas)
        if (
            $request->isMethod('get') &&
            !$request->is('admin*') &&
            !$request->is('panel*')
        ) {
            Visita::create([
                'fecha' => now()
            ]);
        }

        return $response;
    }

}
