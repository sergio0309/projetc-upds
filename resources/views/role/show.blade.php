<div class="modal fade bs-example-modal-sm" id="verRol-{{$role->id}}" tabindex="-1" aria-labelledby="verRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="verRolModalLabel">Rol: {{ $role->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="role_name" class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" id="role_name" value="{{ $role->name }}" disabled />
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="permissions" class="form-label text-muted">Permisos Asociados</label>
                        <select id="permissions" data-choices data-choices-text-disabled-true class="form-control" multiple disabled>
                            @foreach ($permisos as $permiso)
                                <option selected>{{ strtoupper($permiso->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
