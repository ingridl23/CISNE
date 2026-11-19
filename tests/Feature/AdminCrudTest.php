<?php

namespace Tests\Feature;

use App\Models\CategoriasNews;
use App\Models\DireccionHogarModel;
use App\Models\HogarModel;
use App\Models\ImagesHogarModel;
use App\Models\ImagesNoticiasModel;
use App\Models\ImagesProfesionalesModel;
use App\Models\NoticiasModel;
use App\Models\ProfesionalesModel;
use App\Models\RedesHogarModel;
use App\Models\User;
use App\Services\CloudinaryService;
use Database\Seeders\CategoriaNewsSeeder;
use Database\Seeders\RoleAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * CRUD del panel admin (profesionales, noticias, instituciones).
 * Cloudinary se reemplaza por un mock: no se sube nada de verdad.
 */
class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    /** @var MockInterface&CloudinaryService */
    private $cloudinary;

    private int $subidas = 0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleAndPermissionsSeeder::class, CategoriaNewsSeeder::class]);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        // Cada subida devuelve un public_id distinto: carpeta/img1, carpeta/img2, ...
        $this->cloudinary = $this->mock(CloudinaryService::class, function (MockInterface $mock) {
            $mock->shouldReceive('subir')->andReturnUsing(function ($ruta, $carpeta) {
                $n = ++$this->subidas;

                return ['url' => "https://res.cloudinary.com/demo/{$carpeta}/img{$n}.jpg", 'public_id' => "{$carpeta}/img{$n}"];
            });
            $mock->shouldReceive('borrar')->byDefault();
        });
    }

    private function imagen(): UploadedFile
    {
        return UploadedFile::fake()->image('foto.jpg', 200, 200);
    }

    /* ======================= PROFESIONALES ======================= */

    public function test_invitado_no_puede_crear_profesional()
    {
        $this->post('/admin/profesionales', ['nombre' => 'Ana Pérez'])->assertRedirect(route('home'));
        $this->assertSame(0, ProfesionalesModel::count());
    }

    public function test_crear_profesional_con_imagen()
    {
        $this->actingAs($this->admin)
            ->post('/admin/profesionales', [
                'nombre' => 'Ana Pérez',
                'especialidad' => 'Psicología',
                'matricula' => 'MP12345',
                'imagen' => $this->imagen(),
            ])
            ->assertRedirect(route('admin.profesionales'))
            ->assertSessionHasNoErrors();

        $prof = ProfesionalesModel::firstOrFail();
        $this->assertSame('Ana Pérez', $prof->nombre);
        $this->assertDatabaseHas(ImagesProfesionalesModel::class, [
            'profesional_id' => $prof->id,
            'public_id' => 'profesionales/img1',
        ]);
    }

    public function test_crear_profesional_sin_matricula()
    {
        // El navegador manda la matrícula vacía como '' (se convierte a null)
        $this->actingAs($this->admin)
            ->post('/admin/profesionales', [
                'nombre' => 'Ana Pérez',
                'especialidad' => 'Psicología',
                'matricula' => '',
                'imagen' => $this->imagen(),
            ])
            ->assertRedirect(route('admin.profesionales'))
            ->assertSessionHasNoErrors();

        $this->assertNull(ProfesionalesModel::firstOrFail()->matricula);
    }

    public function test_crear_profesional_valida_campos()
    {
        $this->actingAs($this->admin)
            ->post('/admin/profesionales', ['nombre' => 'A'])
            ->assertSessionHasErrors(['nombre', 'especialidad']);

        $this->assertSame(0, ProfesionalesModel::count());
    }

    public function test_editar_profesional_reemplaza_la_imagen()
    {
        $prof = ProfesionalesModel::create(['nombre' => 'Ana', 'especialidad' => 'Psicología', 'matricula' => 'MP12345']);
        ImagesProfesionalesModel::create(['profesional_id' => $prof->id, 'url' => 'https://x/vieja.jpg', 'public_id' => 'profesionales/vieja']);

        $this->cloudinary->shouldReceive('borrar')->once()->with('profesionales/vieja');

        $this->actingAs($this->admin)
            ->put("/admin/profesionales/{$prof->id}", [
                'nombre' => 'Ana María',
                'especialidad' => 'Psiquiatría',
                'imagen' => $this->imagen(),
            ])
            ->assertRedirect(route('admin.profesionales'));

        $this->assertSame('Ana María', $prof->fresh()->nombre);
        $this->assertDatabaseMissing(ImagesProfesionalesModel::class, ['public_id' => 'profesionales/vieja']);
        $this->assertDatabaseHas(ImagesProfesionalesModel::class, ['profesional_id' => $prof->id, 'public_id' => 'profesionales/img1']);
    }

    public function test_editar_imagen_profesional()
    {
        $prof = ProfesionalesModel::create(['nombre' => 'Ana', 'especialidad' => 'Psicología']);
        ImagesProfesionalesModel::create(['profesional_id' => $prof->id, 'url' => 'https://x/vieja.jpg', 'public_id' => 'profesionales/vieja']);

        $this->cloudinary->shouldReceive('borrar')->once()->with('profesionales/vieja');

        $this->actingAs($this->admin)
            ->post("/admin/profesionales/{$prof->id}/imagen", ['imagen' => $this->imagen()])
            ->assertSessionHas('success');

        $this->assertSame(['profesionales/img1'], ImagesProfesionalesModel::pluck('public_id')->all());
    }

    public function test_eliminar_profesional_borra_sus_imagenes()
    {
        $prof = ProfesionalesModel::create(['nombre' => 'Ana', 'especialidad' => 'Psicología']);
        ImagesProfesionalesModel::create(['profesional_id' => $prof->id, 'url' => 'https://x/a.jpg', 'public_id' => 'profesionales/a']);

        $this->cloudinary->shouldReceive('borrar')->once()->with('profesionales/a');

        $this->actingAs($this->admin)->delete("/admin/profesionales/{$prof->id}")->assertRedirect();

        $this->assertSame(0, ProfesionalesModel::count());
        $this->assertSame(0, ImagesProfesionalesModel::count());
    }

    /* ========================== NOTICIAS ========================== */

    public function test_crear_noticia()
    {
        $categoria = CategoriasNews::firstOrFail();

        $this->actingAs($this->admin)
            ->post('/admin/noticias', [
                'titulo' => 'Jornada de salud mental',
                'descripcion' => 'Descripción de la jornada',
                'categoria' => $categoria->id,
                'imagen' => $this->imagen(),
            ])
            ->assertRedirect(route('admin.noticias'))
            ->assertSessionHasNoErrors();

        $noticia = NoticiasModel::firstOrFail();
        $this->assertSame('Jornada de salud mental', $noticia->titulo);
        $this->assertDatabaseHas(ImagesNoticiasModel::class, ['noticia_id' => $noticia->id, 'public_id' => 'noticias/img1']);
    }

    public function test_crear_noticia_exige_imagen_y_categoria_valida()
    {
        $this->actingAs($this->admin)
            ->post('/admin/noticias', ['titulo' => 'Sin imagen', 'descripcion' => 'x', 'categoria' => 9999])
            ->assertSessionHasErrors(['imagen', 'categoria']);

        $this->assertSame(0, NoticiasModel::count());
    }

    public function test_editar_noticia_reemplaza_la_imagen()
    {
        $categoria = CategoriasNews::firstOrFail();
        $noticia = NoticiasModel::create(['titulo' => 'Original', 'descripcion' => 'x', 'categoria_id' => $categoria->id]);
        ImagesNoticiasModel::create(['noticia_id' => $noticia->id, 'url' => 'https://x/vieja.jpg', 'public_id' => 'noticias/vieja']);

        $this->cloudinary->shouldReceive('borrar')->once()->with('noticias/vieja');

        $this->actingAs($this->admin)
            ->put("/admin/noticias/{$noticia->id}", [
                'titulo' => 'Título editado',
                'descripcion' => 'Nueva descripción',
                'categoria' => $categoria->id,
                'imagen' => $this->imagen(),
            ])
            ->assertRedirect(route('admin.noticias'))
            ->assertSessionHasNoErrors();

        $this->assertSame('Título editado', $noticia->fresh()->titulo);
        $this->assertSame(['noticias/img1'], ImagesNoticiasModel::pluck('public_id')->all());
    }

    public function test_eliminar_noticia()
    {
        $categoria = CategoriasNews::firstOrFail();
        $noticia = NoticiasModel::create(['titulo' => 'Borrar', 'descripcion' => 'x', 'categoria_id' => $categoria->id]);
        ImagesNoticiasModel::create(['noticia_id' => $noticia->id, 'url' => 'https://x/a.jpg', 'public_id' => 'noticias/a']);

        $this->cloudinary->shouldReceive('borrar')->once()->with('noticias/a');

        $this->actingAs($this->admin)->delete("/admin/noticias/{$noticia->id}")->assertRedirect();

        $this->assertSame(0, NoticiasModel::count());
        $this->assertSame(0, ImagesNoticiasModel::count());
    }

    /* ======================= INSTITUCIONES ======================= */

    private function datosInstitucion(array $extra = []): array
    {
        return array_merge([
            'nombre' => 'Hogar San José',
            'descripcion' => 'Hogar de día',
            'instagram' => 'hogarsanjose',
            'facebook' => 'hogarsanjose',
            'whatsapp' => '3415551234',
            'provincia' => 'Santa Fe',
            'localidad' => 'Rosario',
            'ciudad' => 'Rosario',
            'calleYAltura' => 'Córdoba 1234',
        ], $extra);
    }

    public function test_crear_institucion_con_imagen()
    {
        $this->actingAs($this->admin)
            ->post('/admin/instituciones', $this->datosInstitucion(['imagen' => $this->imagen()]))
            ->assertRedirect(route('admin.instituciones'))
            ->assertSessionHas('success');

        $hogar = HogarModel::with(['redes', 'direccion'])->firstOrFail();
        $this->assertSame('Hogar San José', $hogar->nombre);
        $this->assertSame('https://instagram.com/hogarsanjose', $hogar->redes->instagram);
        $this->assertSame('Rosario', $hogar->direccion->localidad);
        $this->assertDatabaseHas(ImagesHogarModel::class, ['hogar_id' => $hogar->id, 'public_id' => 'instituciones/img1']);
    }

    public function test_editar_institucion()
    {
        $this->actingAs($this->admin)->post('/admin/instituciones', $this->datosInstitucion(['imagen' => $this->imagen()]));
        $hogar = HogarModel::firstOrFail();

        $this->cloudinary->shouldReceive('borrar')->once()->with('instituciones/img1');

        $this->actingAs($this->admin)
            ->put("/admin/instituciones/{$hogar->id}", $this->datosInstitucion([
                'nombre' => 'Hogar San José (editado)',
                'localidad' => 'Funes',
                'imagen' => $this->imagen(),
            ]))
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $hogar->refresh();
        $this->assertSame('Hogar San José (editado)', $hogar->nombre);
        $this->assertSame('Funes', $hogar->direccion->localidad);
        $this->assertSame(['instituciones/img2'], ImagesHogarModel::pluck('public_id')->all());
    }

    public function test_eliminar_institucion_borra_todo()
    {
        $this->actingAs($this->admin)->post('/admin/instituciones', $this->datosInstitucion(['imagen' => $this->imagen()]));
        $hogar = HogarModel::firstOrFail();

        $this->actingAs($this->admin)
            ->delete("/admin/instituciones/{$hogar->id}")
            ->assertRedirect(route('admin.instituciones'))
            ->assertSessionHas('success');

        $this->assertSame(0, HogarModel::count());
        $this->assertSame(0, ImagesHogarModel::count());
        $this->assertSame(0, DireccionHogarModel::count());
        $this->assertSame(0, RedesHogarModel::count());
    }
}
