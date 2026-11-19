<?php

namespace Tests\Feature;

use App\Models\CategoriasNews;
use App\Models\NoticiasModel;
use Database\Seeders\CategoriaNewsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoticiasPublicasTest extends TestCase
{
    use RefreshDatabase;

    public function test_ver_noticia_existente()
    {
        $this->seed(CategoriaNewsSeeder::class);
        $noticia = NoticiasModel::create([
            'titulo' => 'Jornada de salud mental',
            'descripcion' => 'Descripción',
            'categoria_id' => CategoriasNews::firstOrFail()->id,
        ]);

        $this->get("/noticias/{$noticia->id}")
            ->assertOk()
            ->assertSee('Jornada de salud mental');
    }

    public function test_noticia_inexistente_da_404()
    {
        $this->get('/noticias/99999')->assertNotFound();
    }

    public function test_id_no_numerico_da_404()
    {
        $this->get('/noticias/abc')->assertNotFound();
    }
}
