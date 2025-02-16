<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Pay;
use App\Models\PlantsPay;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $clientId = Client::where('user_id', $userId)->value('id');
        $service_record = ServiceRecord::where('client_id', $clientId)->where('status', 0)->with(['plantsPays', 'type_service'])->get();
        $confirmar_servicio = ServiceRecord::where('client_id', $clientId)->where('status', 1)->with('plantsPays')->get();
        $plants_pay = PlantsPay::all();
        return view('pays.index', compact('service_record','plants_pay', 'confirmar_servicio'));
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
            'service_record_id' => 'required|exists:service_records,id', // Validar que el servicio exista
            'plant_pay_id' => 'required|exists:plants_pays,id', // Validar que el plan de pago exista (corrige el nombre del campo aquí)
            'pay' => 'required|numeric|min:1', // Validar que el monto a pagar sea un número y mayor que 0
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // Validar que el archivo sea de tipo imagen o PDF y no mayor a 10MB
            'status' => 'nullable|numeric'
        ]);

        DB::beginTransaction();
        try {
            // Subir el archivo si se proporciona
            $imagePath = null;
            if ($request->hasFile('file')) {
                $imagePath = $request->file('file')->store('document', 'public');
            }

            // Crear el pago en la tabla `Pay`
            Pay::create([
                'service_record_id' => $request->service_record_id,
                'plant_pay_id' => $request->plant_pay_id, // Cambié payment_plan a plant_pay_id
                'pay' => $request->pay,
                'file' => $imagePath
            ]);

            $service_record = ServiceRecord::findOrFail($request->service_record_id);
            $service_record = ServiceRecord::findOrFail($request->service_record_id);
            if ($request->filled('status')) {
                $service_record->status = $request->status;
                $service_record->save();
            }

            // Confirmar la transacción
            DB::commit();

            // Responder con un mensaje de éxito
            return redirect()->route('pays.index')->with('success', 'Pago registrado exitosamente.');

        } catch (\Exception $e) {
            // Hacer rollback en caso de error
            DB::rollBack();

            // Manejo de excepciones y mostrar el error
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al procesar el pago: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pay $pay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pay $pay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pay $pay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pay $pay)
    {
        //
    }
}
