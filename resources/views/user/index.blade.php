{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
@extends('layouts.app')
@include('user.create')
@section('content')
{{-- @include('layouts.partials.alert') --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Usuarios</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="customerList">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#createUser"><i
                                            class="ri-add-line align-bottom me-1"></i> Añadir</button>
                                    {{-- <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i>
                                    </button> --}}
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
                                        {{-- <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th> --}}
                                        <th class="sort" data-sort="customer_name">N°</th>
                                        <th class="sort" data-sort="customer_name">Nombres</th>
                                        <th class="sort" data-sort="date">Apellidos</th>
                                        <th class="sort" data-sort="email">Correo</th>
                                        <th class="sort" data-sort="phone">Teléfono</th>
                                        <th class="sort" data-sort="status">Status</th>
                                        <th class="sort" data-sort="action">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>
                                        {{-- <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child"
                                                    value="option1">
                                            </div>
                                        </th> --}}
                                        @foreach ($users as $user)
                                        @include('user.edit', ['user' => $user])
                                        <tr>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a>
                                            </td>
                                            <td class="counter">{{ $loop->iteration }}</td>
                                            <td class="customer_name">{{ $user->name}}</td>
                                            <td class="customer_name">{{ $user->last_name}}</td>
                                            <td class="email">{{ $user->email }}</td>
                                            <td class="phone">71818390</td>
                                            <td class="status">
                                                @if ($user->status == 1)
                                                    <span class="badge badge-soft-success text-uppercase">Active</span></td>
                                                @else
                                                    <span class="badge badge-soft-danger text-uppercase">Inactivo</span>
                                                @endif
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-warning edit-item-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editUser-{{$user->id}}">Editar</button>
                                                    </div>
                                                    <div class="remove">
                                                        <button class="btn btn-sm {{ $user->status == 1 ? 'btn-danger' : 'btn-success' }} remove-item-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#confirmarModal-{{ $user->id }}">
                                                            {{ $user->status == 1 ? 'Inhabilitar' : 'Restaurar' }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal-Estado-->
                                        <div class="modal fade" id="confirmarModal-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ $user->status == 1 ? '¿Seguro que quieres desactivar el usuario?' : '¿Seguro que quieres restaurar el usuario?' }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" name="status" value="{{ $user->status }}">
                                                            <button type="submit" class="btn btn-danger">Confirmar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tr>
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
