<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfesionalesModel;
use App\Models\imagesProfesionalesModel;
class ProfesionalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profesionales = [
            [
                'nombre' => 'Dr. Juan Pérez',
                'especialidad' => 'Neurología',
                'matricula' => 'MP1234',
                'url' => 'https://randomuser.me/api/portraits/men/11.jpg'
            ],
            [
                'nombre' => 'Dra. Ana García',
                'especialidad' => 'Psicología',
                'matricula' => 'MP5678',
                'url' => 'https://randomuser.me/api/portraits/women/12.jpg'
            ],
            [
                'nombre' => 'Dr. Martín López',
                'especialidad' => 'Psiquiatría',
                'matricula' => 'MP9101',
                'url' => 'https://randomuser.me/api/portraits/men/13.jpg'
            ],
            [
                'nombre' => 'Dra. Laura Torres',
                'especialidad' => 'Fisioterapia',
                'matricula' => 'MP1121',
                'url' => 'https://randomuser.me/api/portraits/women/14.jpg'
            ],
            [
                'nombre' => 'Dr. Pedro Gómez',
                'especialidad' => 'Kinesiología',
                'matricula' => 'MP3141',
                'url' => 'https://randomuser.me/api/portraits/men/15.jpg'
            ],
            [
                'nombre' => 'Dra. Sofía Martínez',
                'especialidad' => 'Terapia Ocupacional',
                'matricula' => 'MP5161',
                'url' => 'https://randomuser.me/api/portraits/women/16.jpg'
            ],
        ];

        foreach ($profesionales as $data) {
            // Insertar profesional
            $profesional = ProfesionalesModel::create([
                'nombre'       => $data['nombre'],
                'especialidad' => $data['especialidad'],
                'matricula'    => $data['matricula'],
            ]);

            // Insertar su retrato asociado
            imagesProfesionalesModel::create([
                'profesional_id' => $profesional->id,
                'url'            => $data['url'],
                'public_id'      => null,
            ]);
        }
    }
    }

