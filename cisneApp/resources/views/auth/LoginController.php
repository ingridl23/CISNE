<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/showLogin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(){
        Auth::logout();
        return redirect('/showlogin');
    }


    public function login(Request $request)
    {

        if ($request->filled('oculto')) {
            return back()->with("error", "formulario rechazado posible bot detectado"); // posible bot detectado
        }
        // Validar entradas
        $credentials = $request->validate([
            'email' => ['required',  "string",],
            'password' => ['required', "min:8", "max:14"],
        ]);



        // Verificar si el usuario existe
        $user = User::where('email', $credentials['email'])->first();
        // Intentar login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user->assignRole('admin');
            return back()->with('success', 'Logueado  correctamente.');
            return redirect('admin.panel');
        }
        return back()->withErrors([
            'error' => 'Credenciales incorrectas Login.',

        ]);
        return redirect($redirectTo);
    }
}
