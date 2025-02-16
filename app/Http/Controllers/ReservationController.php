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
    public function show( $id)
    {
        $reservation = Reservation::findOrFail($id);
        return response()->json($reservation);
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
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'client_id' => $request->client_id,
            'worker_id' => $request->worker_id,
        ]);

        return response()->json($reservation, 200);
    }

    // Método para eliminar una reservación
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Evento eliminado'], 200);
    }
}
