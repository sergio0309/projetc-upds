<?php

namespace App\Http\Controllers;

use App\Models\PlantsPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlantsPayController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-plan-pagos|crear-plan-pagos|editar-plan-pagos|eliminar-plan-pagos', ['only' => ['index']]);
        $this->middleware('permission:crear-plan-pagos', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-plan-pagos', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-plan-pagos', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plant_pay = PlantsPay::all();
        return view('plant_pay.index', compact('plant_pay'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('plants_pay', 'public');
            }
            $plant = PlantsPay::create([
                'name' => $request->input('name'),
                'image' => $imagePath,
            ]);
            DB::commit();
            return redirect()->route('plant_pay.index')->with('success', 'Plan creado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('plant_pay.index')->with('error', 'Error al crear el plan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantsPay $plantsPay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlantsPay $plantsPay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $plant = PlantsPay::findOrFail($id);

            // Si se sube una nueva imagen, eliminar la anterior
            if ($request->hasFile('image')) {
                if ($plant->image && Storage::disk('public')->exists($plant->image)) {
                    Storage::disk('public')->delete($plant->image);
                }

                // Guardar la nueva imagen
                $imagePath = $request->file('image')->store('plants_pay', 'public');
                $plant->image = $imagePath;
            }

            // Actualizar el nombre del plan
            $plant->name = $request->input('name');
            $plant->save();

            DB::commit();
            return redirect()->route('plant_pay.index')->with('success', 'Plan actualizado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('plant_pay.index')->with('error', 'Error al actualizar el plan.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $plant = PlantsPay::findOrFail($id);
            if ($request->input('status') == 1) {
                $plant->status = 0;
            } else {
                $plant->status = 1;
            }
            $plant->save();
            DB::commit();
            return redirect()->route('plant_pay.index')->with('success', 'Plan actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('plant_pay.index')->with('error', 'Hubo un error al actualizar el plan.');
        }
    }
}
