<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Statement;
use App\Models\Worker;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatementController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-declaracion|crear-declaracion|editar-declaracion|eliminar-declaracion', ['only' => ['index']]);
        $this->middleware('permission:crear-declaracion', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-declaracion', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-declaracion', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with('user')->get();
        $statements = Statement::with('client.user')->get();
        return view('statement.index', compact('clients', 'statements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('statement.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id', // Asegurarse de que el client_id existe en la tabla 'clients'
            'date' => 'required|date', // Validar que sea una fecha
            'sales' => 'nullable|numeric', // Asegurarse de que sea un número
            'discounts' => 'nullable|numeric',
            'purchases' => 'nullable|numeric',
            'recorded_purchases' => 'nullable|numeric',
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
            $statement = Statement::create([
                'client_id' => $validated['client_id'],
                'worker_id' => $worker_id,
                'date' => $validated['date'],
                'sales' => $validated['sales'],
                'discounts' => $validated['discounts'],
                'purchases' => $validated['purchases'],
                'recorded_purchases' => $validated['recorded_purchases'],
                'previous_balance' => $validated['previous_balance'],
                'update' => $validated['update'],
                'current_balance' => $validated['current_balance'],
                'calculated_IVA' => $validated['calculated_IVA'],
                'real_IVA' => $validated['real_IVA'],
                'comp_IUE' => $validated['comp_IUE'],
                'calculated_IT' => $validated['calculated_IT'],
                'real_IT' => $validated['real_IT'],
                'IUE' => $validated['IUE'],
            ]);
            DB::commit();
            return redirect()->route('statements.index')->with('error', 'Declaracion registrada.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('statements.index')->with('error', 'Error al registrar la declaracion.');
        }
        return response()->json([
            'worker_id' => $worker_id,
            'request' => $request->all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Statement $statement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statement $statement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statement $statement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $statement = Statement::findOrFail($id); // Corrección del error findOrFaild
            $statement->delete();

            DB::commit();
            return redirect()->route('statements.index')->with('success', 'Declaración eliminada con éxito.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('statements.index')->with('error', 'Error al eliminar la declaración.');
        }
    }

    public function GenerarPDF($id)
    {
        $statement = Statement::findOrFail($id);
        $client = $statement->client;
        $pdf = Pdf::loadView('statement.pdf', compact('statement'));
        return $pdf->stream('statement.pdf');
    }

}
