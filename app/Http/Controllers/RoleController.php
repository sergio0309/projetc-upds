<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get(); // Obtener todos los roles
        $permisos = Permission::all();
        return view('role.index', compact('roles', 'permisos'));
    }

    public function create()
    {
        $permisos = Permission::all();
        return view('role.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array', // Asegurarte de que los permisos lleguen como array
            'permissions.*' => 'exists:permissions,id', // Validar que cada permiso exista
        ]);

        // Mostrar los datos antes de continuar
        // dd($request->all());  // Verifica si los permisos están en el request

        try {
            DB::beginTransaction();

            // Crear rol
            $rol = Role::create(['name' => strtoupper($request->name)]);

            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $rol->givePermissionTo($permissions);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al crear el rol: ' . $e->getMessage());
        }

        return redirect()->route('roles.index')->with('success', 'Rol registrado');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        // Buscar el rol por su ID
        $rol = Role::findOrFail($id);

        // Recuperar todos los permisos disponibles
        $permisos = Permission::all();

        // Retornar la vista con el rol y los permisos
        return view('role.edit', compact('rol', 'permisos'));
    }

    public function update(Request $request, $id)
    {
        // Validación de datos de entrada
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id, // Validación para asegurar que el nombre no sea duplicado
            'permissions' => 'required|array'
        ]);
        try {
            DB::beginTransaction();
            Role::where('id', $id)
                ->update([
                    'name' => $request->name
                ]);

            $role = Role::findOrFail($id);
            $role->permissions()->sync($request->permissions);

            DB::commit(); // Confirmar transacción

            return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack(); // Si algo falla, revertir la transacción
            // Mostrar error
            return back()->withErrors('Error al actualizar el rol: ' . $e->getMessage());
        }
    }



    public function destroy($id)
    {
        // Eliminar un recurso específico
    }
}
