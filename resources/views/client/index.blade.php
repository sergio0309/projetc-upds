@extends('layouts.app')
@include('client.create', ['users' => $users, 'roles' => $roles])
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Clientes</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createClient">
                                    <i class="ri-add-line align-bottom me-1"></i>Nuevo Cliente
                                </button>
                            </div>
                        </div>
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
                                    <th class="sort" data-sort="customer_name">Cédula Identidad</th>
                                    <th class="sort" data-sort="date">NIT</th>
                                    <th class="sort" data-sort="phone">Celular</th>
                                    <th class="sort" data-sort="date">Fecha de Nacimiento</th>
                                    <th class="sort" data-sort="customer_name">Dirección</th>
                                    <th class="sort" data-sort="action">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($clients as $client)
                                @include('client.edit')
                                @include('client.show')
                                    <tr>
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
                                            <div class="d-flex gap-2">
                                                <div class="show">
                                                    <button type="button" class="btn btn-sm btn-primary" title="Ver"
                                                            data-bs-toggle="modal" data-bs-target="#verClient-{{ $client->user->id }}">
                                                        <i data-feather="eye"></i>
                                                    </button>
                                                </div>

                                                <div class="edit">
                                                    <a href="" class="btn btn-sm btn-warning" title="Editar" data-bs-toggle="modal" data-bs-target="#editClient-{{ $client->user->id }}">
                                                        <i data-feather="edit-3"></i>
                                                    </a>
                                                </div>
                                                <div class="remove">
                                                    <button class="btn btn-sm {{ $client->user->status == 1 ? 'btn-danger' : 'btn-success' }} remove-item-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmarModal-{{ $client->user->id }}"
                                                        title="{{ $client->user->status == 1 ? 'Inhabilitar' : 'Restaurar' }}">
                                                        <i data-feather="refresh-cw"></i>
                                                    </button>
                                                </div>
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
                                                                <form action="{{ route('users.destroy', $client->user->id) }}" method="post">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="{{ $client->user->status }}">
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

