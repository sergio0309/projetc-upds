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
            'descargar-archivo',

            //reporte
            'ver-reporte',
            'crear-reporte',
            'editar-reporte',
            'eliminar-reporte',
            'descargar-reporte',

            //servicio
            'ver-servicio',
            'crear-servicio',
            'editar-servicio',
            'eliminar-servicio',

            //declaracion
            'ver-declaracion',
            'crear-declaracion',
            'editar-declaracion',
            'eliminar-declaracion',

            //consulta
            'ver-consulta',
            'crear-consulta',
            'editar-consulta',
            'eliminar-consulta',

            //plan-pagos
            'ver-plan-pagos',
            'crear-plan-pagos',
            'editar-plan-pagos',
            'eliminar-plan-pagos',

            //pagos
            'ver-pagos',
            'crear-pagos',
            'editar-pagos',
            'eliminar-pagos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
