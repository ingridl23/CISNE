<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::updateOrCreate(
            ['email' => 'cisneconsultorios@gmail.com'],
            [
                'name' => 'CISNE',
                'password' => Hash::make('#.cisne+Consult25Arr'),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole('admin');
        $this->command->info('Usuario admin creado exitosamente!');
    }
}
