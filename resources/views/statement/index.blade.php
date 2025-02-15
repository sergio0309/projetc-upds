@extends('layouts.app')
@include('statement.create')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Declaraciones</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="customerList">
                        <div class="row g-4 mb-3">
                            @can('crear-declaracion')
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-success add-btn"
                                    data-bs-toggle="modal" id="create-btn" data-bs-target="#nuevaDeclaracion">
                                        <i class="ri-add-line align-bottom me-1"></i> Nueva declaracion</button>
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
                                        <th class="sort" data-sort="customer_name">Cliente</th>
                                        <th class="sort" data-sort="customer_name">Cédula de Identidad</th>
                                        <th class="sort" data-sort="customer_name">Fecha de declaración</th>
                                        <th class="sort" data-sort="action">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse ($statements as $index => $statement)
                                    @include('statement.edit', ['statement' => $statement])
                                    @include('statement.show', ['statement' => $statement])
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $statement->client->user->first_name }} {{ $statement->client->user->last_name }}</td>
                                            <td>{{ $statement->client->user->ci }}</td>
                                            <td class="customer_name">{{ strtoupper(\Carbon\Carbon::parse($statement->date)->translatedFormat('d \d\e F \d\e Y')) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-primary edit-item-btn"
                                                        data-bs-toggle="modal" title="Ver" data-bs-target="#verDeclaracion-{{$statement->id}}">
                                                            <i class="ri-eye-fill"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col-sm-auto">
                                                        <div>
                                                            <a href="{{ route('statement.pdf', $statement->id) }}" type="submit" class="btn btn-sm btn-success add-btn">
                                                                <i class="ri-add-line ri-clipboard-fill"></i></a>
                                                        </div>
                                                    </div>

                                                    @can('editar-declaracion')
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-warning edit-item-btn"
                                                        data-bs-toggle="modal" id="create-btn" data-bs-target="#editarDeclaracion-{{$statement->id}}">
                                                            <i class="ri-edit-2-fill"></i>
                                                        </button>
                                                    </div>
                                                    @endcan

                                                    @can('eliminar-declaracion')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#eliminarDeclaracionModal-{{$statement->id}}"
                                                            title="Eliminar">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                    @endcan
                                                    <!-- Modal de Confirmación -->
                                                    <div class="modal fade" id="eliminarDeclaracionModal-{{$statement->id}}" tabindex="-1" aria-labelledby="eliminarDeclaracionModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="eliminarDeclaracionModalLabel">Mensaje de confirmación</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    ¿Seguro que quieres eliminar la declaración de <b>{{ $statement->client->user->name ?? 'Cliente desconocido' }}</b>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                    <form action="{{ route('statements.destroy', $statement->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
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
                                        <td colspan="5" class="text-center text-muted">No existen declaraciones</td>
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
