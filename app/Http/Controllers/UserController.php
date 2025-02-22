<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-user|crear-user|editar-user|eliminar-user', ['only' => ['index']]);
        $this->middleware('permission:crear-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-user', ['only' => ['destroy']]);
    }


    public function index()
    {
        $users = User::paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store( Request $request)
    {
        $request->validate([
            'ci' => 'required|string|max:15|unique:users,ci',
            'complement_ci' => 'nullable|string|max:15|unique:users,complement_ci',
            'nit' => 'nullable|string|max:25|unique:users,nit',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'date_birth' => 'required|date',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_number' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
            }
            $user = User::create([
                'ci' => $request->input('ci'),
                'complement_ci' => $request->input('complement_ci'),
                'nit' => $request->input('nit'),
                'first_name' => strtoupper($request->input('first_name')),
                'last_name' => strtoupper($request->input('last_name')),
                'gender' => $request->input('gender'),
                'date_birth' => $request->input('date_birth'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'email_verified_at' => now(),
                'password' => Hash::make($request->input('password')),
                'status' => 1, // Por defecto, el usuario está activo
                'image' => $imagePath, // Ruta de la imagen almacenada
                'address' => strtoupper($request->input('address')),
                'emergency_contact' => strtoupper($request->input('emergency_contact')),
                'emergency_number' => $request->input('emergency_number'),
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
            'ci' => 'nullable|string|max:15|unique:users,ci,' . $id,
            'complement_ci' => 'nullable|string|max:15|unique:users,complement_ci,' . $id,  // Se añade la validación para complement_ci
            'nit' => 'nullable|string|max:25|unique:users,nit,' . $id, // Asegúrate de especificar la tabla y columna
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string',
            'date_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_number' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Encuentra al usuario por su ID
            $user = User::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($user->image && file_exists(public_path('storage/' . $user->image))) {
                    unlink(public_path('storage/' . $user->image));
                }
                $user->image = $request->file('image')->store('users', 'public');
            }

            $user->ci = $request->input('ci');
            $user->complement_ci = $request->input('complement_ci');
            $user->nit = $request->input('nit');
            $user->first_name = strtoupper($request->input('first_name'));
            $user->last_name = strtoupper($request->input('last_name'));
            $user->gender = $request->input('gender');
            $user->date_birth = $request->input('date_birth');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->address = strtoupper($request->input('address'));
            $user->emergency_contact = strtoupper($request->input('emergency_contact'));
            $user->emergency_number = $request->input('emergency_number');

            // Si la contraseña está presente, actualízala
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save(); // Guarda los cambios

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
