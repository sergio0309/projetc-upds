<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Reservation;
use App\Models\Worker;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_reservations = Reservation::all();
        $clients = Client::all();
        $workers = Worker::all();

        $events = []; // Inicializar $events como un arreglo vacío

        foreach ($all_reservations as $event) {
            $events[] = [
                'title' => $event->title, // Asegúrate de que 'event' sea el nombre correcto del campo
                'start' => $event->start, // Convertir a formato ISO 8601
                'end' => $event->end, // Convertir a formato ISO 8601
                'client_id' => $event->client_id,
                'worker_id' => $event->worker_id
            ];
        }

        return view('calendar.index', compact('events', 'clients', 'workers'));
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
