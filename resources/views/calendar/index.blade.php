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
            <button hidden type="button" class="btn btn-secondary waves-effect waves-light"
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
                                <div class="form-group">
                                    <label for="start">Inicio (Fecha):</label>
                                    <input type="date" class="form-control" name="start" id="start">
                                </div>
                                <div class="form-group">
                                    <label for="start_time">Hora Inicio:</label>
                                    <input type="time" class="form-control" name="start_time" id="start_time">
                                </div>
                                <div class="form-group">
                                    <label for="end">Fin (Fecha):</label>
                                    <input type="date" class="form-control" name="end" id="end">
                                </div>
                                <div class="form-group">
                                    <label for="end_time">Hora Fin:</label>
                                    <input type="time" class="form-control" name="end_time" id="end_time">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btnGuardar" class="btn btn-success">Guardar</button>
                            <button type="submit" id="btnModificar" class="btn btn-warning">Modificar</button>
                            <button type="submit" id="btnEliminar" class="btn btn-danger">Elimnar</button>
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

            let formulario = document.querySelector("form");

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Vista inicial (mes)
                locale: 'es', // Idioma español
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
                navLinks: true, // Permite navegar haciendo clic en un día o semana
                editable: true, // Permite arrastrar y editar eventos
                selectable: true, // Permite seleccionar días o intervalos
                events: @json($events),
                dateClick:function(info){
                    formulario.reset();
                    document.getElementById('start').value = info.dateStr;
                    document.getElementById('end').value = info.dateStr;
                    $("#evento").modal("show");
                }
            });

            calendar.render(); // Renderiza el calendario

            document.getElementById("btnGuardar").addEventListener("click", function(e) {
                e.preventDefault(); // Prevenir el envío normal del formulario


                const title = document.getElementById('title').value;
                const description = document.getElementById('description').value;
                const start = document.getElementById('start').value;
                const end = document.getElementById('end').value;
                const client_id = document.getElementById('client_id').value;
                const worker_id = document.getElementById('worker_id').value;

                const startTime = document.getElementById('start_time').value;
                const endTime = document.getElementById('end_time').value;

                const startDatetime = start + 'T' + startTime;
                const endDatetime = end + 'T' + endTime;

                // Mostrar los valores en la consola para verificar
                console.log('Title:', title);
                console.log('Description:', description);
                console.log('Start:', startDatetime);
                console.log('End:', endDatetime);
                console.log('client_id:', client_id);
                console.log('worker_id:', worker_id);

                // Crear el objeto de datos para enviar al servidor
                const datos = {
                    _token: document.querySelector('input[name="_token"]').value,
                    title: title,
                    description: description,
                    start: startDatetime,
                    end: endDatetime,
                    client_id: client_id,
                    worker_id: worker_id,
                };

                // Enviar los datos al servidor usando Axios
                axios.post("http://127.0.0.1:8000/reservations", datos)
                    .then(response => {
                        // calendar.refetchEvent();
                        console.log(response.data); // Muestra la respuesta para depuración
                        $("#evento").modal("hide"); // Cerrar el modal
                    })
                    .catch(error => {
                        if (error.response) {
                            console.error(error.response.data); // Muestra el error si hay una respuesta del servidor
                        } else {
                            console.error(error); // Muestra cualquier otro error
                        }
                    });
            });
        });
    </script>
@endpush

