<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'agregar profesional',
            'editar  profesional',
            'eliminar profesional',

            'crear noticia',
            'editar noticia',
            'eliminar noticia',

            'agregar flyer',
            'eliminar flyer',
            'modificar telefono'

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $role1 = Role::firstOrCreate(['name' => 'admin']);
        $role2 = Role::firstOrCreate(['name' => 'user']);

        foreach ($permissions as $permission) {
            $role1->givePermissionTo($permission);
        }
    }
}
