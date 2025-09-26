<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use seeders\RoleAndPermissionsSeeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'cisne',
            'email' => 'consultorioscisne@gmail.com',
            'password' => Hash::make('#.cisne+Consult25Arr'),
        ]);
        $user->assignRole('admin');




    }
}
