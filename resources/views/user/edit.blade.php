<div class="modal fade" id="editUser-{{$user->id}}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombres</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Ingresar Nombre" value="{{ $user->name }}" required />
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellidos</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Ingrese Apellido" value="{{ $user->last_name }}" required />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Ingrese correo electrónico" value="{{ $user->email }}" required />
                    </div>

                    <div class="mb-3">
                        <label for="password-input" class="form-label">Contraseña</label>
                        <div class="position-relative auth-pass-inputgroup mb-3">
                            <input type="password" class="form-control pe-5"
                                placeholder="Ingrese Contraseña" id="password-input" name="password" />
                            <button
                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                type="button" id="password-addon"><i
                                    class="ri-eye-fill align-middle"></i></button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirmar Contraseña" />
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-warning" type="submit">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
