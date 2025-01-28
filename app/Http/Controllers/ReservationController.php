<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Reservation;
use App\Models\Worker;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function events(Request $request)
    {
        // Obtiene las reservas dentro del rango de fechas solicitado
        $data = Reservation::whereDate('start', '>=', $request->start)
            ->whereDate('end', '<=', $request->end)
            ->get(['id', 'title', 'start', 'end', 'client_id', 'worker_id']); // Asegúrate de incluir los campos necesarios

        // Responde con los eventos en formato JSON
        return response()->json($data);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with('user')->get();  // Obtener todos los clientes
        $workers = Worker::with('user')->get();
        return view('calendar.index', compact('clients', 'workers'));
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
        $reservation = Reservation::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservations = Reservation::with(['client.user', 'worker.user'])->get();
        return response()->json($reservations);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
