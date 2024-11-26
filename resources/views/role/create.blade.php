<div class="modal fade" id="createRole" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="createRoleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nuevo Rol</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Ingresar Nuevo Rol" required />
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Permisos</label>
                        <select class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="permissions[]" multiple>
                            @foreach ($permisos as $permiso)
                                <option value="{{ $permiso->id }}">{{ $permiso->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
