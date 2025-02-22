@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#border-navs-home" role="tab">Deudas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#border-navs-profile" role="tab">Confirmar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#border-navs-messages" role="tab">Pagados</a>
                    </li>
                </ul>
                <div class="tab-content text-muted">
                    <!-- Tabla Deudas -->
                    <div class="tab-pane active" id="border-navs-home" role="tabpanel">
                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th data-sort="customer_name">N°</th>
                                        <th data-sort="customer_name">Servicio</th>
                                        <th data-sort="date">Fecha de consulta</th>
                                        <th data-sort="customer_name">Deuda del servicio</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                @forelse ($service_record as $service)
                                @include('pays.create')
                                    @if ($service->status === 0) <!-- Solo mostrar si el estado es Inactivo (0) -->
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($service->type_service)
                                                    {{ $service->type_service->name }}
                                                @elseif ($service->statement)
                                                    Declaración
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="counter">{{ strtoupper(optional(\Carbon\Carbon::parse($service->date))->translatedFormat('d \d\e F \d\e Y') ?? 'N/A') }}</td>
                                            <td>
                                                <div style="display: flex; align-items: center;">
                                                    <span>{{ number_format($service->amount, 0, '.', ',') }}</span>
                                                    <span style="margin-left: 5px;">Bs</span>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#pagarServicio-{{$service->id}}" title="Pagar">
                                                    Pagar
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay servicios disponibles.</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{-- Botón de Paginación Anterior --}}
                                <a class="page-item pagination-prev {{ $service_record->onFirstPage() ? 'disabled' : '' }}" href="{{ $service_record->previousPageUrl() }}">
                                    Previous
                                </a>

                                {{-- Lista de Páginas --}}
                                <ul class="pagination listjs-pagination mb-0">
                                    {{-- Mostrar las páginas --}}
                                    @foreach ($service_record->getUrlRange(1, $service_record->lastPage()) as $page => $url)
                                        <li class="page-item {{ $service_record->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Botón de Paginación Siguiente --}}
                                <a class="page-item pagination-next {{ $service_record->hasMorePages() ? '' : 'disabled' }}" href="{{ $service_record->nextPageUrl() }}">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla Confirmar -->
                    <div class="tab-pane" id="border-navs-profile" role="tabpanel">
                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th data-sort="customer_name">N°</th>
                                        <th data-sort="customer_name">Servicio</th>
                                        <th data-sort="date">Fecha de consulta</th>
                                        <th data-sort="customer_name">Deuda del servicio</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse ($confirmar_servicio as $service)
                                    @include('pays.show')
                                        @if ($service->status == 1) <!-- Solo mostrar si el estado es Activo (1) -->
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($service->type_service)
                                                        {{ $service->type_service->name }}
                                                    @elseif ($service->statement)
                                                        Declaración
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="counter">{{ strtoupper(optional(\Carbon\Carbon::parse($service->date))->translatedFormat('d \d\e F \d\e Y') ?? 'N/A') }}</td>
                                                <td>
                                                    <div style="display: flex; align-items: center;">
                                                        <span>{{ number_format($service->amount, 0, '.', ',') }}</span>
                                                        <span style="margin-left: 5px;">Bs</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning">Pendiente</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        {{-- Botón Editar --}}
                                                        <button class="btn btn-sm btn-primary edit-item-btn"
                                                            data-bs-toggle="modal"
                                                            title="Ver"
                                                            data-bs-target="#verPlan-{{$service->id}}"
                                                        >
                                                            <i class="ri-eye-fill"></i>
                                                        </button>

                                                        {{-- Botón Eliminar --}}
                                                        <button class="btn btn-sm btn-warning remove-item-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#EditarPlan-{{$service->id}}"
                                                            title="Editar"
                                                        >
                                                            <i class="ri-edit-2-fill"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay servicios disponibles.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{-- Botón de Paginación Anterior --}}
                                <a class="page-item pagination-prev {{ $confirmar_servicio->onFirstPage() ? 'disabled' : '' }}" href="{{ $confirmar_servicio->previousPageUrl() }}">
                                    Previous
                                </a>

                                {{-- Lista de Páginas --}}
                                <ul class="pagination listjs-pagination mb-0">
                                    {{-- Mostrar las páginas --}}
                                    @foreach ($confirmar_servicio->getUrlRange(1, $confirmar_servicio->lastPage()) as $page => $url)
                                        <li class="page-item {{ $confirmar_servicio->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Botón de Paginación Siguiente --}}
                                <a class="page-item pagination-next {{ $confirmar_servicio->hasMorePages() ? '' : 'disabled' }}" href="{{ $confirmar_servicio->nextPageUrl() }}">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla Pagados -->
                    <div class="tab-pane" id="border-navs-messages" role="tabpanel">
                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th data-sort="customer_name">N°</th>
                                        <th data-sort="customer_name">Servicio</th>
                                        <th data-sort="date">Fecha de consulta</th>
                                        <th data-sort="customer_name">Deuda del servicio</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse ($pay_servicio as $service)
                                    @include('pays.show')
                                        @if ($service->status == 2) <!-- Solo mostrar si el estado es Activo (1) -->
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($service->type_service)
                                                        {{ $service->type_service->name }}
                                                    @elseif ($service->statement)
                                                        Declaración
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="counter">{{ strtoupper(optional(\Carbon\Carbon::parse($service->date))->translatedFormat('d \d\e F \d\e Y') ?? 'N/A') }}</td>
                                                <td>
                                                    <div style="display: flex; align-items: center;">
                                                        <span>{{ number_format($service->amount, 0, '.', ',') }}</span>
                                                        <span style="margin-left: 5px;">Bs</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">Cancelado</span>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay servicios disponibles.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{-- Botón de Paginación Anterior --}}
                                <a class="page-item pagination-prev {{ $pay_servicio->onFirstPage() ? 'disabled' : '' }}" href="{{ $pay_servicio->previousPageUrl() }}">
                                    Previous
                                </a>

                                {{-- Lista de Páginas --}}
                                <ul class="pagination listjs-pagination mb-0">
                                    {{-- Mostrar las páginas --}}
                                    @foreach ($pay_servicio->getUrlRange(1, $pay_servicio->lastPage()) as $page => $url)
                                        <li class="page-item {{ $pay_servicio->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Botón de Paginación Siguiente --}}
                                <a class="page-item pagination-next {{ $pay_servicio->hasMorePages() ? '' : 'disabled' }}" href="{{ $pay_servicio->nextPageUrl() }}">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div>
    </div><!--end col-->
</div><!--end row-->

@endsection

