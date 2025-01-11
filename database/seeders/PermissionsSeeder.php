<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // USUARIOS
            'VER-USER',
            'CREAR-USER',
            'EDITAR-USER',
            'ELIMINAR-USER',

            // ROLES
            'VER-ROLE',
            'CREAR-ROLE',
            'EDITAR-ROLE',
            'ELIMINAR-ROLE',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
