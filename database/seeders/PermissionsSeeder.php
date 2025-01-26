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
            // usuarios
            'ver-user',
            'crear-user',
            'editar-user',
            'eliminar-user',

            // roles
            'ver-role',
            'crear-role',
            'editar-role',
            'eliminar-role',

            //cliente
            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'eliminar-cliente',

            //trabajador
            'ver-trabajador',
            'crear-trabajador',
            'editar-trabajador',
            'eliminar-trabajador',

            //archivo
            'ver-archivo',
            'crear-archivo',
            'editar-archivo',
            'eliminar-archivo',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
