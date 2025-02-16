@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">App</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card card-h-100">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-secondary waves-effect waves-light"
                data-bs-toggle="modal" data-bs-target="#evento">
                Launch
            </button>
            <!-- Modal-Estado-->
            <div class="modal fade" id="evento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Reservación</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                @csrf
                                <div class="form-group">
                                    <label for="client_id">Cliente:</label>
                                    <select name="client_id" id="client_id" class="form-control"
                                        @if (Auth::check() && Auth::user()->client && !Auth::user()->worker) disabled @endif>
                                        <option value="">Selecciona un cliente</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"

                                                @if (Auth::check() && Auth::user()->client && Auth::user()->client->id == $client->id)
                                                    selected
                                                @endif
                                            >
                                                {{ $client->user->last_name }} {{ $client->user->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div><br>

                                <div class="form-group">
                                    <label for="worker_id">Personal:</label>
                                    <select name="worker_id" id="worker_id" class="form-control"
                                        @if (Auth::check() && Auth::user()->worker) disabled @endif>
                                        <option value="">Selecciona el personal</option>
                                        @foreach ($workers as $worker)
                                            <option value="{{ $worker->id }}"
                                                @if (Auth::check() && Auth::user()->worker && Auth::user()->worker->id == $worker->id)
                                                    selected
                                                @endif
                                            >
                                                {{ $worker->user->last_name }} {{ $worker->user->first_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div><br>
                                <div class="form-group">
                                    <label for="title">Título:</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Ingrese el título">
                                </div><br>
                                <div class="form-group">
                                    <label for="description">Descripción:</label>
                                    <textarea class="form-control" name="description" id="description" placeholder="Ingrese la descripción"></textarea>
                                </div><br>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="start">Inicio (Fecha):</label>
                                        <input type="date" class="form-control" name="start" id="start">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="start_time">Hora Inicio:</label>
                                        <input type="time" class="form-control" name="start_time" id="start_time">
                                    </div>
                                </div><br>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="end">Fin (Fecha):</label>
                                        <input type="date" class="form-control" name="end" id="end">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="end_time">Hora Fin:</label>
                                        <input type="time" class="form-control" name="end_time" id="end_time">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnGuardar" class="btn btn-success">Guardar</button>
                            <button type="button" id="btnModificar" class="btn btn-warning">Modificar</button>
                            <button type="button" id="btnEliminar" class="btn btn-danger">Eliminar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.querySelector("form");
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
        navLinks: true,
        editable: true,
        selectable: true,
        events: @json($events),

        eventClick: function(info) {
            // Mostrar modal para editar evento
            $("#evento").modal("show");

            // Cargar datos en los campos del formulario
            document.getElementById('title').value = info.event.title || '';
            document.getElementById('description').value = info.event.extendedProps.description || '';
            document.getElementById('start').value = info.event.start.toISOString().split('T')[0] || '';
            document.getElementById('start_time').value = info.event.start.toISOString().split('T')[1].slice(0, 5) || '';
            document.getElementById('end').value = info.event.end ? info.event.end.toISOString().split('T')[0] : '';
            document.getElementById('end_time').value = info.event.end ? info.event.end.toISOString().split('T')[1].slice(0, 5) : '';
            document.getElementById('client_id').value = info.event.extendedProps.client_id || '';
            document.getElementById('worker_id').value = info.event.extendedProps.worker_id || '';

            // Mostrar botón de Modificar y ocultar Guardar
            document.getElementById("btnModificar").style.display = 'inline-block';
            document.getElementById("btnGuardar").style.display = 'none';

            // Guardar el ID del evento
            document.getElementById('title').dataset.id = info.event.id;
        },

        dateClick: function(info) {
            // Mostrar modal para nuevo evento sin limpiar campos
            $("#evento").modal("show");

            // Establecer fecha seleccionada
            if (!document.getElementById('start').value) {
                document.getElementById('start').value = info.dateStr;
                document.getElementById('end').value = info.dateStr;
            }

            // Mostrar botón de Guardar y ocultar Modificar
            document.getElementById("btnModificar").style.display = 'none';
            document.getElementById("btnGuardar").style.display = 'inline-block';
        }
    });

    calendar.render();

    // Crear nuevo evento
    document.getElementById("btnGuardar").addEventListener("click", function(e) {
        e.preventDefault();

        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;
        const start = document.getElementById('start').value;
        const end = document.getElementById('end').value;
        const client_id = document.getElementById('client_id').value;
        const worker_id = document.getElementById('worker_id').value;
        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;

        const startDatetime = `${start}T${startTime}`;
        const endDatetime = `${end}T${endTime}`;

        const datos = {
            _token: document.querySelector('input[name="_token"]').value,
            title, description, start: startDatetime, end: endDatetime,
            client_id, worker_id
        };

        axios.post("http://127.0.0.1:8000/reservations", datos)
            .then(response => {
                calendar.addEvent({
                    id: response.data.id,
                    title, start: startDatetime, end: endDatetime,
                    extendedProps: { description, client_id, worker_id }
                });

                $("#evento").modal("hide");
            })
            .catch(error => console.error(error));
    });

    // Modificar evento
    // Modificar evento
document.getElementById("btnModificar").addEventListener("click", function(e) {
    e.preventDefault();

    const id = document.getElementById('title').dataset.id;  // Obtener ID del evento
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const start = document.getElementById('start').value;
    const end = document.getElementById('end').value;
    const client_id = document.getElementById('client_id').value;
    const worker_id = document.getElementById('worker_id').value;
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;

    const startDatetime = `${start}T${startTime}`;
    const endDatetime = `${end}T${endTime}`;

    // Datos a enviar para la modificación
    const datos = {
        _token: document.querySelector('input[name="_token"]').value,
        title, description, start: startDatetime, end: endDatetime,
        client_id, worker_id
    };

    // Hacer PUT request para modificar el evento
    axios.put(`http://127.0.0.1:8000/reservations/${id}`, datos)
        .then(response => {
            let event = calendar.getEventById(id);  // Buscar el evento en el calendario
            if (event) {
                // Actualizar los detalles del evento
                event.setProp('title', title);
                event.setExtendedProp('description', description);
                event.setExtendedProp('client_id', client_id);
                event.setExtendedProp('worker_id', worker_id);
                event.setStart(startDatetime);
                event.setEnd(endDatetime);
            }
            $("#evento").modal("hide");  // Cerrar el modal
        })
        .catch(error => console.error(error));
});

// Eliminar evento
document.getElementById("btnEliminar").addEventListener("click", function(e) {
    e.preventDefault();

    const eventId = document.getElementById('title').dataset.id;  // Obtener el ID del evento

    // Hacer DELETE request para eliminar el evento
    axios.delete(`http://127.0.0.1:8000/reservations/${eventId}`)
        .then(response => {
            const event = calendar.getEventById(eventId);  // Buscar el evento en el calendario
            if (event) event.remove();  // Eliminarlo del calendario
            $("#evento").modal("hide");  // Cerrar el modal
        })
        .catch(error => console.error(error));
});


    // Cuando se cierra el modal, los valores del formulario NO se limpian
    $('#evento').on('hidden.bs.modal', function () {
        document.getElementById("btnModificar").style.display = 'none';
        document.getElementById("btnGuardar").style.display = 'inline-block';
    });
});

    </script>
@endpush
