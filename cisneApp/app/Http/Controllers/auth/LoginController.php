<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Maneja el intento de login del usuario
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Debe ser un email válido',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerar la sesión para prevenir session fixation
            $request->session()->regenerate();

            // Redirigir al panel de admin con mensaje de éxito
            return redirect()->intended('/admin/panel')->with('success', '¡Bienvenido de nuevo!');
        }

        // Si las credenciales son incorrectas, volver con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidar la sesión actual
        $request->session()->invalidate();

        // Regenerar el token CSRF
        $request->session()->regenerateToken();

        // Redirigir al home con mensaje
        return redirect('/')->with('success', 'Sesión cerrada correctamente');
    }

    /**
     * Muestra el formulario de login
     */
    public function showLoginForm()
    {
        // Si ya está autenticado, redirigir al panel
        if (Auth::check()) {
            return redirect('/admin/panel');
        }

        return view('layouts.templateHome'); // o la vista que uses para el modal
    }
}
