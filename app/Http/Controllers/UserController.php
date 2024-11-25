<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store( Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'status' => 1, // Por defecto, el usuario está activo
            ]);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Error al registrar el usuario.');
        }
    }

    public function show()
    {

    }

    public function edit( Request $request)
    {
        // return view
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,  // Asegura que el email sea único excepto el del usuario actual
            'password' => 'nullable|string|min:8|confirmed',  // La contraseña es opcional, pero si se llena, debe confirmarse
        ]);

        try {
            DB::beginTransaction();

            // Encuentra al usuario por su ID
            $user = User::findOrFail($id);

            // Actualiza los datos del usuario
            $user->name = $request->input('name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');

            // Si la contraseña está presente, actualízala
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();  // Guarda los cambios

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Error al actualizar el usuario.');
        }
    }

    public function destroy($id, Request $request)
    {
        $user = User::findOrFail($id);

        if ($request->input('status') == 1) {
            $user->status = 0; // Cambia el estado a inactivo
        } else {
            $user->status = 1; // Cambia el estado a activo
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

}
