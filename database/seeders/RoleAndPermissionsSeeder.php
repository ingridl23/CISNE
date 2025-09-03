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
            'crear noticia',
            'editar noticia',
            'eliminar noticia',
            'crear profesional',
            'editar profesional',
            'eliminar profesional',
            'crear hogar',
            'editar hogar',
            'eliminar hogar',
            'ver panel de configuracion',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'user']);

        foreach ($permissions as $permission) {
            $role1->givePermissionTo($permission);
        }
    }
}
