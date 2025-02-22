<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ServiceRecord;
use App\Models\Statement;
use App\Models\TypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceRecords = ServiceRecord::with('client.user', 'worker.user', 'statement', 'type_service')->paginate(10);
        $services = TypeService::all();
        $clients = Client::all();
        return view('service_records.index', compact('services', 'clients', 'serviceRecords'));
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
            'client_id' => 'required|exists:clients,id',
            'type_service_id' => 'nullable|exists:type_services,id', // Verifica si esta tabla es correcta
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',

            // Declaración de valores financieros
            'sales' => 'nullable|numeric|min:0',
            'discounts' => 'nullable|numeric|min:0',
            'purchases' => 'nullable|numeric|min:0',
            'recorded_purchases' => 'nullable|numeric|min:0',
            'previous_balance' => 'nullable|numeric',
            'update' => 'nullable|numeric',
            'current_balance' => 'nullable|numeric',
            'calculated_IVA' => 'nullable|numeric',
            'real_IVA' => 'nullable|numeric',
            'comp_IUE' => 'nullable|numeric',
            'calculated_IT' => 'nullable|numeric',
            'real_IT' => 'nullable|numeric',
            'IUE' => 'nullable|numeric',
        ]);
        $worker_id = Auth::user()->worker->id;
        try {
            DB::beginTransaction();
            $statement_id = null;
            if (!empty($request->sales)) {
                $statement = Statement::create([
                    'sales' => $request->sales,
                    'discounts' => $request->discounts,
                    'purchases' => $request->purchases,
                    'recorded_purchases' => $request->recorded_purchases,
                    'previous_balance' => $request->previous_balance,
                    'update' => $request->update,
                    'current_balance' => $request->current_balance,
                    'calculated_IVA' => $request->calculated_IVA,
                    'real_IVA' => $request->real_IVA,
                    'comp_IUE' => $request->comp_IUE,
                    'calculated_IT' => $request->calculated_IT,
                    'real_IT' => $request->real_IT,
                    'IUE' => $request->IUE,
                ]);
                $statement_id = $statement->id;
            }
            ServiceRecord::create([
                'date' => now(),  // Fecha automática
                'amount' => $request->amount,
                'description' => $request->description,
                'type_service_id' => $request->type_service_id,
                'client_id' => $request->client_id,
                'worker_id' => $worker_id,
                'statement_id' => $statement_id, // Puede ser null si no se creó
            ]);

            DB::commit();

            return redirect()->route('service_records.index')->with('success', 'Servicio creado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('service_records.index')->with('error', 'Error al crear el servicio.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRecord $serviceRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRecord $serviceRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'type_service_id' => 'nullable|exists:type_services,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',

            // Validación de valores financieros
            'sales' => 'nullable|numeric|min:0',
            'discounts' => 'nullable|numeric|min:0',
            'purchases' => 'nullable|numeric|min:0',
            'recorded_purchases' => 'nullable|numeric|min:0',
            'previous_balance' => 'nullable|numeric',
            'update' => 'nullable|numeric',
            'current_balance' => 'nullable|numeric',
            'calculated_IVA' => 'nullable|numeric',
            'real_IVA' => 'nullable|numeric',
            'comp_IUE' => 'nullable|numeric',
            'calculated_IT' => 'nullable|numeric',
            'real_IT' => 'nullable|numeric',
            'IUE' => 'nullable|numeric',
        ]);
        try {
            DB::beginTransaction();
            $serviceRecord = ServiceRecord::findOrFail($id);
            $statement_id = null;
            if (!empty($request->sales) || !empty($request->discounts) || !empty($request->purchases)) {

                $statement = $serviceRecord->statement ?? new Statement();

                $statement->sales = $request->sales;
                $statement->discounts = $request->discounts;
                $statement->purchases = $request->purchases;
                $statement->recorded_purchases = $request->recorded_purchases;
                $statement->previous_balance = $request->previous_balance;
                $statement->update = $request->update;
                $statement->current_balance = $request->current_balance;
                $statement->calculated_IVA = $request->calculated_IVA;
                $statement->real_IVA = $request->real_IVA;
                $statement->comp_IUE = $request->comp_IUE;
                $statement->calculated_IT = $request->calculated_IT;
                $statement->real_IT = $request->real_IT;
                $statement->IUE = $request->IUE;
                $statement->save();
                $statement_id = $statement->id;
            }
            $serviceRecord->update([
                'amount' => $request->amount,
                'description' => $request->description,
                'type_service_id' => $request->type_service_id,
                'client_id' => $request->client_id,
                'statement_id' => $statement_id, // Asignamos el statement_id al ServiceRecord
            ]);
            DB::commit();
            return redirect()->route('service_records.index')->with('success', 'Servicio actualizado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('service_records.index')->with('error', 'Error al actualizar el servicio.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $serviceRecord = ServiceRecord::findOrFail($id);
            $serviceRecord->delete();
            return redirect()->route('service_records.index')->with('success', 'Servicio eliminado.');
        } catch (\Exception $e) {
            return redirect()->route('service_records.index')->with('error', 'Error al eliminar el servicio.');
        }
    }
}
