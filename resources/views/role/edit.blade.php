<div class="modal fade" id="editarRol-{{$role->id}}" tabindex="-1" aria-labelledby="editarRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="editarRolLabel">Editar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Rol</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $role->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="permissions" class="form-label">Permisos</label>
                        <select class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem multiple name="permissions[]">
                            @foreach ($permisos as $permiso)
                                <option value="{{ $permiso->id }}" {{ $role->permissions->contains($permiso->id) ? 'selected' : '' }}>
                                    {{ $permiso->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
