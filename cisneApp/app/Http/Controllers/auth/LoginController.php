<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
public function login(Request $request)
{
$credentials = $request->validate([
'email' => ['required','email'],
'password' => ['required'],
]);

if (Auth::attempt($credentials)) {
$request->session()->regenerate(); // evita sesión vieja
return redirect()->intended('/admin/panel'); // donde quieras
}

return back()->withErrors([
'email' => 'Las credenciales no coinciden.',
])->withInput();
}

public function logout(Request $request)
{
Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();
return redirect('/panel');
}
}
