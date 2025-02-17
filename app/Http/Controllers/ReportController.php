<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ServiceRecord;
use App\Models\Statement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $client = Client::with('user')->where('user_id', $userId)->first();
        if (!$client) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
        $serviceRecords = ServiceRecord::with('statement')
            ->where('client_id', $client->id)
            ->get();
        // return response()->json($serviceRecords);
        return view('reports.index', compact('client', 'serviceRecords'));
    }

    public function GenerarPDF($id)
    {
        $statement = Statement::findOrFail($id);

        // Obtiene el service record relacionado con el statement
        $serviceRecord = $statement->serviceRecord;

        // Verifica si el service record existe
        if (!$serviceRecord) {
            return response()->json(['error' => 'No se encontró un registro de servicio para este estado'], 404);
        }

        // Accede al cliente asociado con el service record
        $client = $serviceRecord->client;

        // Accede al usuario asociado con el cliente
        $user = $client->user;
        // return response()->json([
        //     $statement, $client, $user
        // ]);

        // Carga la vista del PDF pasando el statement, client y user
        $pdf = Pdf::loadView('reports.pdf', compact('statement', 'client', 'user'));

        // Devuelve el PDF generado para ser mostrado
        return $pdf->stream('reports.pdf');
    }

    public function anualGenerarPDF($id)
    {
        // Obtener el cliente con los datos del usuario
        $client = Client::with('user')->findOrFail($id);

        // Obtener los registros de servicio asociados al cliente y sus declaraciones
        $serviceRecord = ServiceRecord::where('client_id', $client->id)
                                    ->with('statement')
                                    ->get();

        // Filtrar los registros de servicio para mantener solo aquellos con datos útiles
        $filteredServiceRecord = $serviceRecord->filter(function ($record) {
            return optional($record->statement)->sales !== null;
        });

        // Inicializar los totales
        $totals = [
            'sales' => 0,
            'discounts' => 0,
            'purchases' => 0,
            'recorded_purchases' => 0,
            'previous_balance' => 0,
            'update' => 0,
            'current_balance' => 0,
            'calculated_IVA' => 0,
            'real_IVA' => 0,
            'comp_IUE' => 0,
            'calculated_IT' => 0,
            'real_IT' => 0,
            'IUE' => 0,
        ];

        // Sumar los totales
        foreach ($filteredServiceRecord as $record) {
            $statement = $record->statement;

            $totals['sales'] += $statement->sales ?? 0;
            $totals['discounts'] += $statement->discounts ?? 0;
            $totals['purchases'] += $statement->purchases ?? 0;
            $totals['recorded_purchases'] += $statement->recorded_purchases ?? 0;
            $totals['previous_balance'] += $statement->previous_balance ?? 0;
            $totals['update'] += $statement->update ?? 0;
            $totals['current_balance'] += $statement->current_balance ?? 0;
            $totals['calculated_IVA'] += $statement->calculated_IVA ?? 0;
            $totals['real_IVA'] += $statement->real_IVA ?? 0;
            $totals['comp_IUE'] += $statement->comp_IUE ?? 0;
            $totals['calculated_IT'] += $statement->calculated_IT ?? 0;
            $totals['real_IT'] += $statement->real_IT ?? 0;
            $totals['IUE'] += $statement->IUE ?? 0;
        }

        // Generar el PDF con los registros filtrados y los totales
        $pdf = Pdf::loadView('reports.anual_pdf', compact('filteredServiceRecord', 'client', 'totals'));

        // Retornar el PDF para visualización o descarga
        return $pdf->stream('reporte_anual.pdf');
    }


}
