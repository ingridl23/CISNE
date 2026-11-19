<?php

namespace Tests\Feature;

use App\Mail\ConfirmacionFormulario;
use App\Mail\EnvioDeForm;
use App\Models\InstitucionContacto;
use App\Models\Paciente_Contacto;
use App\Models\ProfesionalEnvioCV;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Modal "CONTACTO" de la home: POST /contacto (FormController@enviar).
 */
class FormularioContactoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Storage::fake('public');
    }

    public function test_particular_guarda_contacto_y_envia_dos_mails()
    {
        $this->from('/')->post('/contacto', [
            'opcion' => 'particular',
            'name' => 'Juan Gómez',
            'email' => 'juan@example.com',
            'tel' => '3415551234',
        ])->assertRedirect('/')->assertSessionHas('success');

        $this->assertDatabaseHas(Paciente_Contacto::class, ['email' => 'juan@example.com']);
        Mail::assertSent(EnvioDeForm::class, fn ($m) => $m->hasTo('cisneconsultorios@gmail.com'));
        Mail::assertSent(ConfirmacionFormulario::class, fn ($m) => $m->hasTo('juan@example.com'));
    }

    public function test_paciente_no_puede_enviar_dos_veces_el_mismo_email()
    {
        $datos = ['opcion' => 'particular', 'name' => 'Juan Gómez', 'email' => 'juan@example.com', 'tel' => '3415551234'];

        $this->from('/')->post('/contacto', $datos)->assertSessionHas('success');
        Mail::assertSentCount(2);

        // Segundo envío con el mismo email: error de validación claro, sin mails ni registro nuevo
        $this->from('/')->post('/contacto', $datos)
            ->assertRedirect('/')
            ->assertSessionHasErrors(['email' => 'Ya recibimos una consulta con este email. El equipo CISNE se va a poner en contacto a la brevedad.']);

        $this->assertSame(1, Paciente_Contacto::count());
        Mail::assertSentCount(2);
    }

    public function test_el_mismo_email_puede_usarse_como_institucion_o_profesional()
    {
        $this->from('/')->post('/contacto', ['opcion' => 'particular', 'name' => 'Juan Gómez', 'email' => 'juan@example.com']);

        // La restricción es solo para pacientes
        $this->from('/')->post('/contacto', ['opcion' => 'institucion', 'name' => 'Hogar Juan', 'email' => 'juan@example.com'])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    public function test_institucion_guarda_contacto()
    {
        // El navegador manda el teléfono vacío como '' (se convierte a null)
        $this->from('/')->post('/contacto', [
            'opcion' => 'institucion',
            'name' => 'Hogar San José',
            'email' => 'hogar@example.com',
            'tel' => '',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas(InstitucionContacto::class, ['email' => 'hogar@example.com']);
        Mail::assertSent(EnvioDeForm::class);
    }

    public function test_profesional_envia_cv_adjunto_y_borra_el_archivo_local()
    {
        $this->from('/')->post('/contacto', [
            'opcion' => 'profesional',
            'name' => 'Ana Pérez',
            'email' => 'ana@example.com',
            'cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
        ])->assertSessionHas('success');

        $registro = ProfesionalEnvioCV::firstOrFail();
        $this->assertSame('ana@example.com', $registro->email);

        // El CV va como adjunto en el mail al administrador...
        Mail::assertSent(EnvioDeForm::class, function (EnvioDeForm $mail) {
            $mail->build();
            return $mail->hasAttachment($mail->data['cv']->getRealPath(), ['as' => 'cv.pdf', 'mime' => 'application/pdf']);
        });

        // ...y la copia local se borra después del envío
        Storage::disk('public')->assertMissing($registro->cv_path);
    }

    public function test_profesional_sin_cv_falla_la_validacion()
    {
        $this->from('/')->post('/contacto', [
            'opcion' => 'profesional',
            'name' => 'Ana Pérez',
            'email' => 'ana@example.com',
        ])->assertSessionHasErrors('cv');

        $this->assertSame(0, ProfesionalEnvioCV::count());
        Mail::assertNothingSent();
    }

    public function test_honeypot_rechaza_bots()
    {
        $this->from('/')->post('/contacto', [
            'opcion' => 'particular',
            'name' => 'Bot Bot',
            'email' => 'bot@example.com',
            'oculto' => 'soy un bot',
        ])->assertSessionHas('error');

        $this->assertSame(0, Paciente_Contacto::count());
        Mail::assertNothingSent();
    }
}
