@extends('layouts.app')
@include('client.create', ['users' => $users, 'roles' => $roles])
@section('content')
{{-- @foreach($clients as $client)
    @foreach($client->serviceRecords as $serviceRecord)
        <p>{{ $serviceRecord->description }}</p>
        <p>{{ $serviceRecord->status}}</p>
        @foreach($serviceRecord->pays as $pay)
            <p>Pago: {{ $pay->pay }}</p>
            <p>Archivo: <a href="{{ asset($pay->file) }}" target="_blank">{{ $pay->file }}</a></p>
        @endforeach
    @endforeach
@endforeach --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        @can('crear-cliente')
                        <div class="col-sm-auto">
                            <div>
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createClient">
                                    <i class="ri-add-line align-bottom me-1"></i>Nuevo Cliente
                                </button>
                            </div>
                        </div>
                        @endcan
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th data-sort="customer_name">N°</th>
                                    <th data-sort="customer_name">Cliente</th>
                                    <th data-sort="customer_name">Cédula Identidad</th>
                                    <th data-sort="date">NIT</th>
                                    <th data-sort="phone">Celular</th>
                                    <th data-sort="date">Fecha de Nacimiento</th>
                                    <th data-sort="customer_name">Dirección</th>
                                    <th data-sort="customer_name">Estado</th>
                                    <th data-sort="action">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($clients as $client)
                                @include('client.edit')
                                @include('client.show')
                                @include('client.pay')
                                    <tr>
                                        @php
                                            // Contar la cantidad de registros de servicio con status == 1 para el cliente
                                            $serviceRecordCount = $client->serviceRecords->where('status', 1)->count();
                                        @endphp
                                        <td class="counter">{{ $loop->iteration }}</td>
                                        <td class="customer_name">{{ $client->user->first_name ?? 'N/A' }} {{ $client->user->last_name ?? 'N/A' }}</td>
                                        <td>{{ $client->user->ci }}</td>
                                        @if ( $client->user->nit )
                                            <td class="counter">{{ $client->user->nit }}</td>
                                        @else
                                            <td class="counter" style="opacity: 0.5;">N/A</td>
                                        @endif
                                        <td>{{ $client->user->phone ?? 'N/A' }}</td>
                                        <td>{{ strtoupper(optional(\Carbon\Carbon::parse($client->user->date_birth))->translatedFormat('d \d\e F \d\e Y') ?? 'N/A') }}</td>
                                        <td>{{ $client->user->address ?? 'N/A' }}</td>
                                        <td>
                                            @if ($client->user->status == 1)
                                                <span class="badge badge-soft-success text-uppercase">Active</span>
                                            @else
                                                <span class="badge badge-soft-danger text-uppercase">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">

                                                <div class="show" style="position: relative;">
                                                    <button type="button" class="btn btn-sm btn-success" title="Pagar"
                                                            data-bs-toggle="modal" data-bs-target="#pagarCliente-{{ $client->id }}">
                                                        <i class="ri-funds-fill"></i>
                                                    </button>

                                                    @if ($serviceRecordCount > 0)
                                                        <span class="badge rounded-pill bg-danger text-white position-absolute top-0 start-100 translate-middle" style="font-size: 10px;">
                                                            {{ $serviceRecordCount }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="modal fade bs-example-modal-sm" id="pagarCliente-{{ $client->id }}" tabindex="-1" aria-labelledby="pagarClienteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content ">
                                                            <div class="modal-header bg-light p-3">
                                                                <h5 class="modal-title" id="pagarClienteModalLabel">Pagar</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                                                    id="close-modal"></button>
                                                            </div>
                                                            <form action="{{ route('clients.pay')}}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row mb-4">
                                                                        <table class="table align-middle table-nowrap" id="customerTable">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th class="text-center">Seleccionar</th> <!-- Título de la columna "Seleccionar" -->
                                                                                    <th class="text-center">N°</th>
                                                                                    <th class="text-center">Tipo de Servicio</th>
                                                                                    <th class="text-center">Deuda</th>
                                                                                    <th class="text-center">Monto a Pagar</th>
                                                                                    <th class="text-center">Documento/Comprobante</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="list form-check-all">
                                                                                @php $counter = 1; @endphp
                                                                                @foreach ($client->serviceRecords as $servicio)
                                                                                    @if ($servicio->status == 1)
                                                                                        <tr>
                                                                                            <td class="text-center">
                                                                                                <input type="checkbox" name="service_records[]" value="{{ $servicio->id }}">
                                                                                            </td>
                                                                                            <td class="text-center">{{ $counter }}</td> <!-- Mostrar el número actual -->
                                                                                            <td class="text-center">
                                                                                                {{ $servicio->type_service?->name ?? ($servicio->statement?->name ?? 'Declaracion') }}
                                                                                            </td>
                                                                                            <td class="text-center">{{ $servicio->amount }}</td>
                                                                                            <td class="text-center">
                                                                                                {{ $servicio->pays->isNotEmpty() ? $servicio->pays->first()->pay : 'N/A' }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                @if ($servicio->pays->isNotEmpty() && $servicio->pays->first()->file)
                                                                                                    <a href="{{ asset('storage/' . $servicio->pays->first()->file) }}" target="_blank" download class="btn btn-sm btn-primary" title="Descargar">
                                                                                                        <i class="ri-file-3-fill"></i>
                                                                                                    </a>
                                                                                                @else
                                                                                                    N/A
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                        @php $counter++; @endphp <!-- Incrementar después de imprimir -->
                                                                                    @endif
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-center">
                                                                    <button type="submit" class="btn btn-success" id="add-btn">Pagar</button>
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="show">
                                                    <button type="button" class="btn btn-sm btn-primary" title="Ver"
                                                            data-bs-toggle="modal" data-bs-target="#verClient-{{ $client->user->id }}">
                                                        <i class="ri-eye-fill"></i>
                                                    </button>
                                                </div>

                                                @can('editar-cliente')
                                                <div class="edit">
                                                    <a href="" class="btn btn-sm btn-warning" title="Editar" data-bs-toggle="modal" data-bs-target="#editClient-{{ $client->user->id }}">
                                                        <i class="ri-edit-2-fill"></i>
                                                    </a>
                                                </div>
                                                @endcan

                                                @can('eliminar-cliente')
                                                <div class="remove">
                                                    <button class="btn btn-sm {{ $client->user->status == 1 ? 'btn-danger' : 'btn-success' }} remove-item-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmarModal-{{ $client->user->id }}"
                                                        title="{{ $client->user->status == 1 ? 'Inhabilitar' : 'Restaurar' }}">
                                                        <i class="ri-refresh-line"></i>
                                                    </button>
                                                </div>
                                                @endcan
                                                <!-- Modal-Estado-->
                                                <div class="modal fade" id="confirmarModal-{{ $client->user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $client->user->id == 1 ? '¿Seguro que quieres desactivar el usuario?' : '¿Seguro que quieres restaurar el usuario?' }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                <form action="{{ route('clients.destroy', $client->user->id) }}" method="post">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="{{ $client->user->status }}">
                                                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="remove">
                                                    <button class="btn btn-sm btn-info remove-item-btn" data-bs-toggle="modal" data-bs-target="#documento-{{ $client->id }}" title="Documentos">
                                                        <i class="ri-file-3-fill"></i>
                                                    </button>
                                                </div>

                                                <!-- Modal para mostrar documentos -->
                                                <div class="modal fade" id="documento-{{ $client->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table class="table align-middle table-nowrap">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>N°</th>
                                                                                <th>Fecha</th>
                                                                                <th>Acción</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @forelse ($client->files as $file)
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>
                                                                                        {{ strtoupper(\Carbon\Carbon::parse($file->data)->translatedFormat('d \d\e F \d\e Y')) }}
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="d-flex gap-2">
                                                                                            <!-- Botón para abrir el modal de vista previa -->
                                                                                            {{-- <button title="Ver" class="btn btn-sm btn-primary view-file-btn" data-bs-toggle="modal"
                                                                                                data-bs-target="#viewFileModal-{{$file->id}}" data-file-url="{{ $file->file_url }}" data-file-type="{{ $file->file_type }}">
                                                                                                <i class="ri-eye-fill"></i>
                                                                                            </button> --}}

                                                                                            <!-- Botón para descargar el archivo -->
                                                                                            <a href="{{ route('files.download', $file->id) }}" title="Descargar archivo" class="btn btn-sm btn-success">
                                                                                                <i class="ri-folder-download-fill"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @empty
                                                                                <tr>
                                                                                    <td colspan="3" class="text-center">Sin documentos</td>
                                                                                </tr>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                    orders for you search.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="#">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="#">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>
@endsection

{{-- @push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const viewFileButtons = document.querySelectorAll('.view-file-btn');
            viewFileButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileUrl = this.getAttribute('data-file-url');
                    const fileType = this.getAttribute('data-file-type');
                    const previewContainer = document.getElementById('file-preview-container');

                    // Limpiar cualquier contenido previo
                    previewContainer.innerHTML = '';

                    // Mostrar vista previa según el tipo de archivo
                    if (fileType.startsWith('image/')) {
                        // Vista previa para imágenes
                        previewContainer.innerHTML = `<img src="${fileUrl}" alt="Vista previa" class="img-fluid" />`;
                    } else if (fileType === 'application/pdf') {
                        // Vista previa para PDFs
                        previewContainer.innerHTML = `<iframe src="${fileUrl}" class="img-fluid" style="height: 500px;" frameborder="0"></iframe>`;
                    } else {
                        // Si el archivo no tiene vista previa disponible
                        previewContainer.innerHTML = `<p>Vista previa no disponible para este tipo de archivo.</p>`;
                    }
                });
            });
        });

    </script>
@endpush --}}
