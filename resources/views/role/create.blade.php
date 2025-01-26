@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Crear Rol</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nuevo Rol</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Ingresar Nuevo Rol" required />
                                </div>

                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>

                    <div class="border mt-3 border-dashed"></div>

                    <div class="mt-4">
                        <h6 class="mb-3 fs-15 text-muted">Permisos</h6>
                        <div class="row">
                            @foreach ($permisos as $permiso)
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permiso->id }}"
                                            id="permiso-{{ $permiso->id }}">
                                        <label class="form-check-label" for="permiso-{{ $permiso->id }}">
                                            {{ $permiso->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border mt-3 border-dashed"></div>

                    <div class="mt-4 d-flex justify-content-center">
                        <a href="{{ route('roles.index') }}" class="btn btn-light me-2">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar Rol</button>
                    </div>

                </form><!-- end form -->
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>

@endsection
