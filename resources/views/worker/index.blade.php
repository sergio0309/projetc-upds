@extends('layouts.app')
@include('worker.create', ['workers' => $workers, 'roles' => $roles])
@section('content')
@include('layouts.alerts.alert')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        @can('crear-trabajador')
                        <div class="col-sm-auto">
                            <div>
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createWorker">
                                    <i class="ri-add-line align-bottom me-1"></i>Nuevo Trabajador
                                </button>
                            </div>
                        </div>
                        @endcan
                    </div>
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th data-sort="customer_name">N°</th>
                                    <th data-sort="customer_name">Trabajador</th>
                                    <th data-sort="customer_name">Cédula Identidad</th>
                                    <th data-sort="date">NIT</th>
                                    <th data-sort="phone">Celular</th>
                                    <th data-sort="date">Fecha de Nacimiento</th>
                                    <th data-sort="customer_name">Dirección</th>
                                    <th data-sort="action">Estado</th>
                                    <th data-sort="action">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($workers as $worker)
                                @include('worker.edit', ['workers' => $workers])
                                @include('worker.show')
                                    <tr>
                                        <td class="counter">{{ $loop->iteration }}</td>
                                        <td class="customer_name">{{ $worker->user->first_name ?? 'N/A' }} {{ $worker->user->last_name ?? 'N/A' }}</td>
                                        <td>{{ $worker->user->ci ?? 'N/A' }}</td>
                                        <td>{{ $worker->user->nit ?? 'N/A' }}</td>
                                        <td>{{ $worker->user->phone ?? 'N/A' }}</td>
                                        <td>{{ strtoupper(optional(\Carbon\Carbon::parse($worker->user->date_birth))->translatedFormat('d \d\e F \d\e Y') ?? 'N/A') }}</td>
                                        <td>{{ $worker->user->address ?? 'N/A' }}</td>
                                        <td>
                                            @if ($worker->user->status == 1)
                                                <span class="badge badge-soft-success text-uppercase">Active</span>
                                            @else
                                                <span class="badge badge-soft-danger text-uppercase">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <div class="show">
                                                    <button type="button" class="btn btn-sm btn-primary" title="Ver"
                                                            data-bs-toggle="modal" data-bs-target="#verWorker-{{ $worker->user->id }}">
                                                        <i class="ri-eye-fill"></i>
                                                    </button>
                                                </div>

                                                @can('editar-trabajador')
                                                <div class="edit">
                                                    <a href="" class="btn btn-sm btn-warning" title="Editar" data-bs-toggle="modal" data-bs-target="#editWorker-{{ $worker->user->id }}">
                                                        <i class="ri-edit-2-fill"></i>
                                                    </a>
                                                </div>
                                                @endcan

                                                @can('eliminar-trabajador')
                                                <div class="remove">
                                                    <button class="btn btn-sm {{ $worker->user->status == 1 ? 'btn-danger' : 'btn-success' }} remove-item-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmarModal-{{ $worker->user->id }}"
                                                        title="{{ $worker->user->status == 1 ? 'Inhabilitar' : 'Restaurar' }}">
                                                        <i class="ri-refresh-line"></i>
                                                    </button>
                                                </div>
                                                @endcan
                                                <!-- Modal-Estado-->
                                                <div class="modal fade" id="confirmarModal-{{ $worker->user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $worker->user->id == 1 ? '¿Seguro que quieres desactivar el usuario?' : '¿Seguro que quieres restaurar el usuario?' }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                <form action="{{ route('workers.destroy', $worker->user->id) }}" method="post">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="{{ $worker->user->status }}">
                                                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                                                </form>
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
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            {{-- Botón de Paginación Anterior --}}
                            <a class="page-item pagination-prev {{ $workers->onFirstPage() ? 'disabled' : '' }}" href="{{ $workers->previousPageUrl() }}">
                                Previous
                            </a>

                            {{-- Lista de Páginas --}}
                            <ul class="pagination listjs-pagination mb-0">
                                {{-- Mostrar las páginas --}}
                                @foreach ($workers->getUrlRange(1, $workers->lastPage()) as $page => $url)
                                    <li class="page-item {{ $workers->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Botón de Paginación Siguiente --}}
                            <a class="page-item pagination-next {{ $workers->hasMorePages() ? '' : 'disabled' }}" href="{{ $workers->nextPageUrl() }}">
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

