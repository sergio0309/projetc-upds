@extends('layouts.app')
@include('typeservice.create')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Roles</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="customerList">
                        <div class="row g-4 mb-3">
                            @can('crear-servicio')
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#crearServicio"><i
                                            class="ri-add-line align-bottom me-1"></i>Nuevo Servicio</button>
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
                                        <th class="sort" data-sort="customer_name">N°</th>
                                        <th class="sort" data-sort="customer_name">Servicio</th>
                                        <th class="sort" data-sort="customer_name">Estado</th>
                                        <th class="sort" data-sort="action">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse ($types_service as $service)
                                    @include('typeservice.edit', ['service' => $service])
                                        <tr>
                                            <td class="counter">{{ $loop->iteration }}</td>
                                            <td class="counter">{{ $service->name }}</td>
                                            <td class="status">
                                                @if ($service->status == 1)
                                                    <span class="badge badge-soft-success text-uppercase">Activo</span>
                                                @else
                                                    <span class="badge badge-soft-danger text-uppercase">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-primary edit-item-btn"
                                                            data-bs-toggle="modal" title="Ver" data-bs-target="#verRol-"><i class="ri-eye-fill"></i></button>
                                                    </div>
                                                    @can('editar-servicio')
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-warning edit-item-btn"
                                                        data-bs-toggle="modal" title="Editar" data-bs-target="#editarServicio-{{$service->id}}">
                                                            <i class="ri-edit-2-fill"></i>
                                                        </button>
                                                    </div>
                                                    @endcan

                                                    @can('eliminar-servicio')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal" data-bs-target="#confirmarModal-{{ $service->id }}"
                                                            title="{{ $service->status == 1 ? 'Inhabilitar' : 'Restaurar' }}">
                                                            <i class="ri-refresh-line"></i>
                                                        </button>
                                                    </div>
                                                    @endcan
                                                    <!-- Modal-Estado-->
                                                    <div class="modal fade" id="confirmarModal-{{ $service->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{ $service->status == 1 ? '¿Seguro que quieres desactivar el servicio?' : '¿Seguro que quieres restaurar el servicio?' }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                    <form action="{{ route('typesservice.destroy', $service->id) }}" method="post">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="{{ $service->status }}">
                                                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Sin Servicios Registrados</td>
                                        </tr>
                                    @endforelse
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
