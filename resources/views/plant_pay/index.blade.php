@extends('layouts.app')
@include('plant_pay.create')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        {{-- @can('crear-servicio') --}}
                        <div class="col-sm-auto">
                            <div>
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#crearPlan"><i
                                        class="ri-add-line align-bottom me-1"></i>Nuevo Plan de Pago</button>
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
                                    <th class="sort" data-sort="customer_name">Nombre - Plan de Pago</th>
                                    <th class="sort" data-sort="customer_name">Estado</th>
                                    <th class="sort" data-sort="action">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @forelse ($plant_pay as $plant)
                                @include('plant_pay.show')
                                @include('plant_pay.edit')
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $plant->name }}</td>
                                        <td class="status">
                                            <span class="badge {{ $plant->status ? 'badge-soft-success' : 'badge-soft-danger' }} text-uppercase">
                                                {{ $plant->status ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="phone">
                                            <div class="d-flex gap-2">
                                                <div class="edit">
                                                    <button class="btn btn-sm btn-primary edit-item-btn"
                                                        data-bs-toggle="modal"
                                                        title="Ver"
                                                        data-bs-target="#verPlan-{{$plant->id}}">
                                                        <i class="ri-eye-fill"></i></i>
                                                    </button>
                                                </div>

                                                {{-- @can('editar-user') --}}
                                                <div class="edit">
                                                    <button class="btn btn-sm btn-warning edit-item-btn"
                                                        data-bs-toggle="modal"
                                                        title="Editar"
                                                        data-bs-target="#editarPlan-{{$plant->id}}">
                                                        <i class="ri-edit-2-fill"></i>
                                                    </button>
                                                </div>
                                                {{-- @endcan --}}

                                                {{-- @can('eliminar-user') --}}
                                                <div class="remove">
                                                    <button class="btn btn-sm btn-danger remove-item-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#eliminarPlan-{{$plant->id}}"
                                                        title="Eliminar"
                                                        >
                                                        <i class="ri-refresh-line"></i>
                                                    </button>
                                                </div>
                                                {{-- @endcan --}}
                                            </div>
                                            <!-- Modal-Estado-->
                                            <div class="modal fade" id="eliminarPlan-{{$plant->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $plant->status == 1 ? '¿Seguro que quieres desactivar el plan?' : '¿Seguro que quieres restaurar el plan?' }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            <form action="{{ route('plant_pay.destroy', $plant->id) }}" method="post">
                                                                @method('DELETE')
                                                                @csrf
                                                                <input type="hidden" name="status" value="{{ $plant->status }}">
                                                                <button type="submit" class="btn btn-danger">Confirmar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <div class="alert alert-warning p-3 m-0" role="alert">
                                                <i class="bi bi-exclamation-triangle-fill"></i> Sin planes de pago
                                            </div>
                                        </td>
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
