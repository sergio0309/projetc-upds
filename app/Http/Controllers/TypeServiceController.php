<?php

namespace App\Http\Controllers;

use App\Models\TypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TypeServiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-servicio|crear-servicio|editar-servicio|eliminar-servicio', ['only' => ['index']]);
        $this->middleware('permission:crear-servicio', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-servicio', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-servicio', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types_service = TypeService::all();
        return view('typeservice.index', compact('types_service'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'  // 'required' en lugar de 'require'
        ]);
        try {
            DB::beginTransaction();
            $service = TypeService::create([
                'name' => $request->input('name'),
                'status' => 1,
            ]);
            DB::commit();
            return redirect()->route('typesservice.index')->with('success', 'Servicio creado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('typesservice.index')->with('error', 'Error al crear el servicio.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeService $typeService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeService $typeService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string'  // 'required' en lugar de 'require'
        ]);
        try {
            DB::beginTransaction();
            $service = TypeService::findOrFail($id);
            $service->name = $request->input('name');
            $service->save();
            DB::commit();
            return redirect()->route('typesservice.index')->with('success', 'Servicio actualizadp exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('typesservice.index')->with('error', 'Error al actualizar el servicio.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $service = TypeService::findOrFail($id);

        if ($request->input('status') == 1) {
            $service->status = 0; // Cambia el estado a inactivo
        } else {
            $service->status = 1; // Cambia el estado a activo
        }

        $service->save();

        return redirect()->route('typesservice.index')->with('success', 'Servicio actualizado correctamente.');
    }
}
