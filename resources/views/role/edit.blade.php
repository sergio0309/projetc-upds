@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Editar Rol</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <form action="{{ route('roles.update', $rol->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre del Rol</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name', $rol->name) }}" placeholder="Ingresar Nuevo Rol" required />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>

                    <div class="border mt-3 border-dashed"></div>

                    <div class="mt-4">
                        <h6 class="mb-3 fs-15 text-muted">Permisos para el Rol:</h6>
                        <div class="row">
                            @foreach ($permisos as $permiso)
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input

                                            type="checkbox"
                                            name="permissions[]"
                                            id="permiso-{{ $permiso->id }}"
                                            class="form-check-input"
                                            value="{{ $permiso->id }}"
                                            {{ $rol->permissions->contains($permiso->id) ? 'checked' : '' }}>
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
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>

                </form><!-- end form -->
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
@endsection
