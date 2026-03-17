<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\CategoriasNews;

class CategoriaNewsSeeder extends Seeder
{
    public function run()
    {
        CategoriasNews::create(['nombre' => 'Turno']);
        CategoriasNews::create(['nombre' => 'Evento']);
        CategoriasNews::create(['nombre' => 'Postulacion']);
    }
}