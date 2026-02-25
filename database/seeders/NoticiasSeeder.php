<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\noticiasModel;
use App\Models\imagesNoticiasModel;
class NoticiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $noticias = [
            [
                'titulo' => 'Nueva apertura de centro tecnológico',
                'descripcion' => 'Se inauguró un nuevo centro tecnológico para impulsar la innovación en la región.',
                'categoria' => 'Tecnología',
                'imagenes' => [
                    ['url' => 'https://picsum.photos/seed/noticia1/400/300', 'public_id' => 'noticia1_img1'],
                    ['url' => 'https://picsum.photos/seed/noticia1b/400/300', 'public_id' => 'noticia1_img2'],
                ],
            ],
            [
                'titulo' => 'Campeonato deportivo local',
                'descripcion' => 'El campeonato local reunió a más de 200 participantes en diferentes disciplinas.',
                'categoria' => 'Deportes',
                'imagenes' => [
                    ['url' => 'https://picsum.photos/seed/noticia2/400/300', 'public_id' => 'noticia2_img1'],
                ],
            ],
            [
                'titulo' => 'Avances en medicina regenerativa',
                'descripcion' => 'Investigadores locales presentan nuevos tratamientos con células madre.',
                'categoria' => 'Salud',
                'imagenes' => [
                    ['url' => 'https://picsum.photos/seed/noticia3/400/300', 'public_id' => 'noticia3_img1'],
                ],
            ],
            [
                'titulo' => 'Festival gastronómico 2025',
                'descripcion' => 'El evento culinario más esperado del año vuelve con más de 100 stands.',
                'categoria' => 'Gastronomía',
                'imagenes' => [
                    ['url' => 'https://picsum.photos/seed/noticia4/400/300', 'public_id' => 'noticia4_img1'],
                ],
            ],
            [
                'titulo' => 'Exposición de arte urbano',
                'descripcion' => 'Artistas internacionales presentan sus obras en el centro cultural.',
                'categoria' => 'Cultura',
                'imagenes' => [
                    ['url' => 'https://picsum.photos/seed/noticia5/400/300', 'public_id' => 'noticia5_img1'],
                    ['url' => 'https://picsum.photos/seed/noticia5b/400/300', 'public_id' => 'noticia5_img2'],
                ],
            ],
            [
                'titulo' => 'Conferencia sobre energías renovables',
                'descripcion' => 'Expertos en energía solar y eólica comparten experiencias en un foro internacional.',
                'categoria' => 'Medio Ambiente',
                'imagenes' => [
                    ['url' => 'https://picsum.photos/seed/noticia6/400/300', 'public_id' => 'noticia6_img1'],
                ],
            ],
        ];

        foreach ($noticias as $n) {
            $noticia = noticiasModel::create([
                'titulo' => $n['titulo'],
                'descripcion' => $n['descripcion'],
                'categoria' => $n['categoria'],
            ]);

            foreach ($n['imagenes'] as $img) {
 imagesNoticiasModel::create([
                    'noticia_id' => $noticia->id,
                    'url' => $img['url'],
                    'public_id' => $img['public_id'],
                ]);
            }
        }
    }

        }

