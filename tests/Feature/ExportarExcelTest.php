<?php

namespace Tests\Feature;

use App\Models\InstitucionContacto;
use App\Models\Paciente_Contacto;
use App\Models\ProfesionalEnvioCV;
use App\Models\User;
use Database\Seeders\RoleAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tests\TestCase;

/**
 * Descarga de contactos en Excel desde el panel (GET /admin/panel/descargas).
 * Genera el .xlsx de verdad (maatwebsite/excel + PhpSpreadsheet) y lo vuelve a leer.
 */
class ExportarExcelTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionsSeeder::class);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    /** Descarga el Excel y devuelve sus filas como array */
    private function descargar(string $tipo, array $filtros = []): array
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/panel/descargas?' . http_build_query(['tipo' => $tipo] + $filtros));

        $response->assertOk();
        $response->assertDownload();

        return IOFactory::load($response->getFile()->getPathname())->getActiveSheet()->toArray();
    }

    public function test_exportar_pacientes()
    {
        $p = Paciente_Contacto::create(['nombre' => 'Juan Gómez', 'email' => 'juan@example.com', 'telefono' => '3415551234']);

        $filas = $this->descargar('pacientes');

        $this->assertSame(['ID', 'Nombre', 'Email', 'Telefono', 'Fecha Registro'], $filas[0]);
        $this->assertSame([(string) $p->id, 'Juan Gómez', 'juan@example.com', '3415551234', $p->created_at->format('Y-m-d')], $filas[1]);
        $this->assertCount(2, $filas);
    }

    public function test_exportar_pacientes_filtra_por_fecha()
    {
        $viejo = Paciente_Contacto::create(['nombre' => 'Viejo', 'email' => 'viejo@example.com', 'telefono' => null]);
        $viejo->forceFill(['created_at' => '2025-01-15'])->save();
        Paciente_Contacto::create(['nombre' => 'Nuevo', 'email' => 'nuevo@example.com', 'telefono' => null]);

        $filas = $this->descargar('pacientes', ['desde' => now()->subDay()->format('Y-m-d')]);

        $this->assertCount(2, $filas);
        $this->assertSame('Nuevo', $filas[1][1]);
    }

    public function test_exportar_profesionales()
    {
        ProfesionalEnvioCV::create(['nombre' => 'Ana Pérez', 'email' => 'ana@example.com', 'telefono' => null, 'cv_path' => 'cvs/ana.pdf']);

        $filas = $this->descargar('profesionales');

        $this->assertSame(['ID', 'Nombre', 'Email', 'Telefono', 'CV'], $filas[0]);
        $this->assertSame(['Ana Pérez', 'ana@example.com', null, 'cvs/ana.pdf'], array_slice($filas[1], 1));
    }

    public function test_exportar_instituciones()
    {
        InstitucionContacto::create(['nombre' => 'Hogar San José', 'email' => 'hogar@example.com', 'telefono' => '3415550000']);

        $filas = $this->descargar('hogares');

        $this->assertSame(['ID', 'Nombre', 'Email', 'Telefono'], $filas[0]);
        $this->assertSame(['Hogar San José', 'hogar@example.com', '3415550000'], array_slice($filas[1], 1));
    }

    public function test_tipo_invalido_vuelve_atras()
    {
        $this->actingAs($this->admin)->from('/admin/panel')
            ->get('/admin/panel/descargas?tipo=otro')
            ->assertRedirect('/admin/panel');
    }
}
