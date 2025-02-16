@extends('layouts.app')
@section('content')
{{-- @include('layouts.partials.alert') --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="customerList">
                        <div class="row g-4 mb-3">
                            @can('crear-role')
                            <div class="col-sm-auto">
                                <div>
                                    <a href="{{route('roles.create')}}" type="button" class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> Crear nuevo Rol</a>
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
                                        <th data-sort="customer_name">Role</th>
                                        <th data-sort="action">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($roles as $role)
                                    @include('role.show', ['role' => $role, 'permisos' => $permisos])
                                        <tr>
                                            <td class="id" style="display:none;">
                                                <a href="javascript:void(0);" class="fw-medium link-primary">#{{ $role->id }}</a>
                                            </td>
                                            <td class="counter">{{ $loop->iteration }}</td>
                                            <td class="customer_name">{{ $role->name }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-primary edit-item-btn"
                                                            data-bs-toggle="modal" title="Ver" data-bs-target="#verRol-{{$role->id}}" ><i class="ri-eye-fill"></i></i></button>
                                                    </div>
                                                    @can('editar-role')
                                                    <div class="edit">
                                                        <a class="btn btn-sm btn-warning edit-item-btn" href="{{ route('roles.edit', $role->id) }}"><i class="ri-edit-2-fill"></i></i></a>
                                                    </div>
                                                    @endcan
                                                    {{-- <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal"><i data-feather="refresh-cw"></i></button>
                                                    </div> --}}
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
