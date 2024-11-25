<div class="modal fade" id="createUser" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="createUserModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- <div class="mb-3" id="modal-id" style="display: none;">
                        <label for="id-field" class="form-label">ID</label>
                        <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                    </div> --}}

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombres</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Ingresar Nombre"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellidos</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Ingrese Apellido"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="email-field" class="form-label">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Ingrese correo electrónico"
                            required />
                    </div>

                    {{-- <div class="mb-3">
                        <label for="phone-field" class="form-label">Telefono</label>
                        <input type="text" id="phone-field" class="form-control" placeholder="Enter Phone no."
                            required />
                    </div> --}}

                    <div class="mb-3">
                        {{-- <div class="float-end">
                            <a href="auth-pass-reset-cover" class="text-muted">Forgot
                                password?</a>
                        </div> --}}
                        <label class="form-label" for="password-input">Contraseña</label>
                        <div class="position-relative auth-pass-inputgroup mb-3">
                            <input type="password" class="form-control pe-5"
                                placeholder="Ingrese Contraseña" id="password-input" name="password">
                            <button
                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                type="button" id="password-addon"><i
                                    class="ri-eye-fill align-middle"></i></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="username" name="password_confirmation"
                            placeholder="Confirmar Contraseña">
                    </div>

                    {{-- <div>
                        <label for="status-field" class="form-label">Rol</label>
                        <select class="form-control" data-trigger name="status-field" id="status-field">
                            <option value="">----</option>
                            <option value="Active">Active</option>
                            <option value="Block">Block</option>
                        </select>
                    </div> --}}
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
