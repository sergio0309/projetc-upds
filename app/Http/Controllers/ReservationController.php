<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Reservation;
use App\Models\Worker;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-reserva|crear-reserva|editar-reserva|eliminar-reserva', ['only' => ['index']]);
        $this->middleware('permission:crear-reserva', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-reserva', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-reserva', ['only' => ['destroy']]);
    }

    public function index()
    {
        $all_reservations = Reservation::all();
        $clients = Client::all();
        $workers = Worker::all();

        $events = []; // Inicializar $events como un arreglo vacío

        foreach ($all_reservations as $event) {
            $events[] = [
                'id' => $event->id,
                'title' => $event->title, // Asegúrate de que 'event' sea el nombre correcto del campo
                'start' => $event->start, // Convertir a formato ISO 8601
                'end' => $event->end, // Convertir a formato ISO 8601
                'client_id' => $event->client_id,
                'worker_id' => $event->worker_id
            ];
        }
        // return response()->json($events);
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
        try {
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
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Método para eliminar una reservación
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Evento eliminado'], 200);
    }
}
