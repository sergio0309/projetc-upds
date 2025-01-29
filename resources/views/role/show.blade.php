<div class="modal fade bs-example-modal-sm" id="verRol-{{ $role->id }}" tabindex="-1" aria-labelledby="verRolModalLabel-{{ $role->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="verRolModalLabel-{{ $role->id }}">Rol: {{ $role->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="role_name_{{ $role->id }}" class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" id="role_name_{{ $role->id }}" value="{{ $role->name }}" disabled />
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Permisos Asociados</strong>
                    </div>
                    <div class="card-body">
                        <label class="form-label text-muted">Permisos</label>
                        <div class="row">
                            @foreach ($permisos as $permiso)
                                <div class="col-md-4">
                                    <input disabled
                                        type="checkbox"
                                        id="permiso-{{ $role->id }}-{{ $permiso->id }}"
                                        value="{{ $permiso->id }}"
                                        class="form-check-input"
                                        {{ $role->permissions->contains($permiso->id) ? 'checked' : '' }}>
                                    <label for="permiso-{{ $role->id }}-{{ $permiso->id }}" class="form-check-label text-uppercase text-muted">
                                        {{ strtoupper($permiso->name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
