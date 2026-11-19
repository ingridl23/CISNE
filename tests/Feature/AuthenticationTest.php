<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * El login es un modal en la home que hace POST /login
 * (App\Http\Controllers\Auth\LoginController).
 */
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_login_redirige_a_la_home()
    {
        $this->get('/login')->assertRedirect(route('home'));
    }

    public function test_invitado_que_entra_al_admin_va_a_la_home()
    {
        $this->get('/admin/panel')->assertRedirect(route('home'));
    }

    public function test_usuario_puede_loguearse()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/admin/panel');
    }

    public function test_usuario_no_puede_loguearse_con_password_incorrecta()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_usuario_puede_cerrar_sesion()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout')->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_registro_publico_deshabilitado()
    {
        $this->get('/register')->assertNotFound();
    }
}
