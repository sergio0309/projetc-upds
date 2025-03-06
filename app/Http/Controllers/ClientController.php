<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ServiceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cliente|crear-cliente|editar-cliente|eliminar-cliente', ['only' => ['index']]);
        $this->middleware('permission:crear-cliente', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-cliente', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-cliente', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $clients = Client::with([
            'user',
            'files',
            'serviceRecords.pays',
            'serviceRecords.type_service',
            'serviceRecords.statement'
        ])->paginate(10);
        $serviceRecord = ServiceRecord::with('pays')->get();
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('client.index', compact('clients', 'users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $roles = Role::all();
        return view('client.create', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('Llegó aquí', $request->all());
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'ci' => 'nullable|string|max:15|unique:users,ci',
            'complement_ci' => 'nullable|string|max:15|unique:users,complement_ci',
            'nit' => 'nullable|string|max:25|unique:users,nit',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string',
            'date_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_number' => 'nullable|string|max:255',
            'email_2' => 'nullable|string|email|max:255|unique:clients,email_2',
            'password_2' => 'nullable|string|min:8',
            'deadline' => 'nullable|string|max:255',
            'rol' => 'nullable|integer|exists:roles,id'
        ]);

        try {
            DB::beginTransaction();

            if (!is_null($request->input('user_id')) ) {

                $user = User::findOrFail($request->user_id);

                Client::create([
                    'email_2' => $request->input('email_2'),
                    'deadline' => $request->input('deadline'),
                    'password_2' => Hash::make($request->input('password_2')),
                    'user_id' => $user->id
                ]);

                $role = Role::findOrFail($request->input('rol'));
                $user->assignRole($role);

                DB::commit();
                return redirect()->route('clients.index')->with('success', 'Cliente asociado al usuario existente creado exitosamente.');
            }

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
                'status' => 1,
                'image' => $imagePath,
                'address' => strtoupper($request->input('address')),
                'emergency_contact' => strtoupper($request->input('emergency_contact')),
                'emergency_number' => $request->input('emergency_number'),
            ]);

            $roleId = $request->input('rol');
            $role = Role::findOrFail($roleId);
            $user->assignRole($role);

            Client::create([
                'email_2' => $request->input('email_2'),
                'deadline' => $request->input('deadline'),
                'user_id' => $user->id,
            ]);

            DB::commit();
            return redirect()->route('clients.index')->with('success', 'Cliente creado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('clients.index')->with('Error', 'Error al registrar el cliente');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ci' => 'nullable|string|max:15|unique:users,ci,' . $id,
            'complement_ci' => 'nullable|string|max:15|unique:users,complement_ci,' . $id,
            'nit' => 'nullable|string|max:25|unique:users,nit,' . $id,
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
            'email_2' => 'nullable|string|email|max:255|unique:clients,email_2',
            'deadline' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
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

            $client = Client::where('user_id', $id)->firstOrFail();
            $client->update([
                'email_2' => $request->input('email_2'),
                'deadline' => $request->input('deadline'),
            ]);

            DB::commit();
            return redirect()->route('clients.index')->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('clients.index')->with('Error', 'Error al actualizar el cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $user = User::findOrFail($id);

            if ($request->input('status') == 1) {
                $user->status = 0; // Cambia el estado a inactivo
                $message = 'Cliente desactivado correctamente.';
            } else {
                $user->status = 1; // Cambia el estado a activo
                $message = 'Cliente activado correctamente.';
            }

            $user->save();

            return redirect()->route('clients.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Error al actualizar el estado del cliente: ' . $e->getMessage());
        }
    }

    public function pay(Request $request)
    {
        try {
            $serviceRecordIds = $request->input('service_records');

            if (!$serviceRecordIds || !is_array($serviceRecordIds)) {
                return redirect()->route('clients.index')->with('error', 'No se seleccionaron registros de servicio válidos.');
            }

            // Buscar los registros de ServiceRecord y cargar la relación con Pays
            $serviceRecords = ServiceRecord::with('pays') // Cargar relación pays
                ->whereIn('id', $serviceRecordIds)
                ->get();

            if ($serviceRecords->isEmpty()) {
                return redirect()->route('clients.index')->with('error', 'No se encontraron registros de servicio para actualizar.');
            }

            // Iterar sobre los registros de ServiceRecord y actualizar la relación con Pay
            foreach ($serviceRecords as $serviceRecord) {
                // Obtener el primer pago relacionado (si existe)
                $firstPay = $serviceRecord->pays->first();

                // Si hay al menos un pago relacionado, actualizar
                if ($firstPay) {
                    $serviceRecord->update([
                        'status' => 2,
                        'amount' => 0,
                        'paid' => $firstPay->pay // Usa el primer pago de la relación
                    ]);
                } else {
                    return redirect()->route('clients.index')->with('error', 'Uno o más registros no tienen pagos asociados.');
                }
            }

            return redirect()->route('clients.index')->with('success', 'Pagos actualizados correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Error al actualizar los pagos: ' . $e->getMessage());
        }
    }
}
