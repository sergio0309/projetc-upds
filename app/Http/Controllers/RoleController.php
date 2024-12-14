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
        $roles = Role::all(); // Obtener todos los roles
        $permisos = Permission::all();
        return view('role.index', compact('roles', 'permisos'));
    }

    public function create()
    {
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
            $rol = Role::create(['name' => $request->name]);

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
        // Mostrar un recurso específico
    }

    public function edit($id)
    {
        // Mostrar el formulario para editar un recurso específico
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);


        try {
            DB::beginTransaction();

            $role = Role::findOrFail($id);
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            DB::commit();

            return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al actualizar el rol: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        // Eliminar un recurso específico
    }
}
