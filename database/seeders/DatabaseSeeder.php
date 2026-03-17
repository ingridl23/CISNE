<?php

namespace Database\Seeders;
use Database\Seeders\CategoriaNewsSeeder;
use Database\Seeders\RoleAndPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleAndPermissionsSeeder::class,
            UserSeeder::class, // Después crear usuarios y asignarles roles
            CategoriaNewsSeeder::class,

        ]);
    }
}
