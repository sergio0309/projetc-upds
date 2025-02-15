@extends('layouts.app')
@include('service_records.create')
@include('service_records.statement')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="customerList">
                        <div class="row g-4 mb-3">
                            {{-- @can('crear-user') --}}
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#nuevoServicio"><i
                                            class="ri-add-line align-bottom me-1"></i>Nueva Consulta</button>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal"
                                        id="declaraciones-btn" data-bs-target="#declaracion">
                                        <i class="ri-file-text-line align-bottom me-1"></i> Declaracion
                                    </button>
                                </div>
                            </div>
                            {{-- @endcan --}}
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
                                        <th class="sort" data-sort="customer_name">N°</th>
                                        <th class="sort" data-sort="customer_name">Servicio</th>
                                        <th class="sort" data-sort="date">Fecha de consulta</th>
                                        <th class="sort" data-sort="customer_name">Cliente</th>
                                        <th class="sort" data-sort="customer_name">Deuda del servicio</th>
                                        <th class="sort" data-sort="customer_name">Cancelado</th>
                                        <th class="sort">Estado - Servicio</th>
                                        <th class="sort" data-sort="action">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ( $serviceRecords as $service )
                                    @include('service_records.edit', ['service' => $service, 'services' => $services])
                                    @include('service_records.show', ['service' => $service, 'services' => $services])
                                    @include('service_records.statement_edit', ['service' => $service])
                                    @include('service_records.statement_show', ['service' => $service])
                                    <tr>
                                        <td class="counter">{{ $loop->iteration }}</td>
                                        <td class="customer_name">
                                            @if ($service->type_service)
                                                {{ $service->type_service->name }}
                                            @elseif ($service->statement)
                                                Declaración
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="counter">{{ strtoupper(optional(\Carbon\Carbon::parse($service->date))->translatedFormat('d \d\e F \d\e Y') ?? 'N/A') }}</td>
                                        <td class="counter">{{ $service->client->user->first_name }} {{ $service->client->user->last_name }}</td>
                                        <td class="phone">
                                            <div style="display: flex; align-items: center;">
                                                <span>{{ number_format($service->amount, 0, '.', ',') }}</span>
                                                <span style="margin-left: 5px;">Bs</span>
                                            </div>
                                        </td>
                                        <td>{{$service->paid}}</td>
                                        <td class="status">
                                                @if ($service->status_debt == 1)
                                                    <span class="badge badge-soft-success text-uppercase">Cancelado</span></td>
                                                @else
                                                    <span class="badge badge-soft-danger text-uppercase">Deuda</span>
                                                @endif
                                        </td>
                                        <td class="phone">
                                            <div class="d-flex gap-2">
                                                <div class="edit">
                                                    <button class="btn btn-sm btn-primary edit-item-btn"
                                                        data-bs-toggle="modal"
                                                        title="Ver"
                                                        {{-- data-bs-target="#verServicio-{{$service->id}}"> --}}
                                                        data-bs-target="#{{ $service->type_service_id ? 'verServicio' : 'verDeclaracion' }}-{{$service->id}}">
                                                        <i class="ri-eye-fill"></i></i>
                                                    </button>
                                                </div>

                                                {{-- @can('editar-user') --}}
                                                <div class="edit">
                                                    <button class="btn btn-sm btn-warning edit-item-btn"
                                                        data-bs-toggle="modal"
                                                        title="Editar"
                                                        data-bs-target="#{{ $service->type_service_id ? 'editarServicio' : 'editarDeclaracion' }}-{{$service->id}}">
                                                        <i class="ri-edit-2-fill"></i>
                                                    </button>
                                                </div>
                                                {{-- @endcan --}}

                                                {{-- @can('eliminar-user') --}}
                                                <div class="remove">
                                                    <button class="btn btn-sm btn-danger remove-item-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#eliminarServicio-{{$service->id}}"
                                                        title="Eliminar"
                                                        >
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                                {{-- @endcan --}}
                                            </div>
                                            <!-- Modal-Estado-->
                                            <div class="modal fade" id="eliminarServicio-{{$service->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Seguro que quieres eliminar la consulta?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            <form action="{{ route('service_records.destroy', $service->id) }}" method="post">
                                                                @method('DELETE')
                                                                @csrf
                                                                <input type="hidden" name="status" value="">
                                                                <button type="submit" class="btn btn-danger">Confirmar</button>
                                                            </form>
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
        </div>
        <!-- end col -->
    </div>
@endsection
