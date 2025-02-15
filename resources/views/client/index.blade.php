@extends('layouts.app')
@include('client.create', ['users' => $users, 'roles' => $roles])
@section('content')
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
                                            @if ($client->user->status == 1)
                                                <span class="badge badge-soft-success text-uppercase">Active</span>
                                            @else
                                                <span class="badge badge-soft-danger text-uppercase">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
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

