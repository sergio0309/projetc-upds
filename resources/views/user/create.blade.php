<div class="modal fade bs-example-modal-sm" id="createUser" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="editUserModalLabel">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label for="first_name" class="form-label">Nombres</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Ingresar Nombre" required />
                        </div>

                        <div class="col-md-4">
                            <label for="last_name" class="form-label">Apellidos</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Ingrese Apellido" required />
                        </div>

                        <div class="col-md-4">
                            <label for="gender" class="form-label">Seleccione género</label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="" disabled selected>Género</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="col-md-5">
                            <label for="ci" class="form-label">Cédula de Identidad</label>
                            <input type="number" id="ci" name="ci" class="form-control" placeholder="Ingresar CI" required />
                        </div>

                        <div class="col-md-3">
                            <label for="complement_ci" class="form-label">Complemento CI</label>
                            <input type="text" id="complement_ci" name="complement_ci" class="form-control" placeholder="Complemento"/>
                        </div>

                        <div class="col-md-4">
                            <label for="enable_nit" class="form-check-label">
                                <input type="checkbox" id="enable_nit" class="form-check-input" />
                                NIT
                            </label>
                            <input type="number" id="nit" name="nit" class="form-control mt-2" placeholder="Ingresar NIT" disabled />
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="date_birth" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" id="date_birth" name="date_birth" class="form-control" placeholder="Ingrese Fecha de nacimiento">
                        </div>

                        <div class="col-md-3">
                            <label for="phone" class="form-label">Número de Celular</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Ingrese celular">
                        </div>
                        <div class="col-md-6">
                            <label for="email-field" class="form-label">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Ingrese correo electrónico"
                                required />
                        </div>
                    </div>
                    {{-- <div class="row mb-3">
                    </div> --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="password-input">Contraseña</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control pe-5"
                                    placeholder="Ingrese Contraseña" id="password-input" name="password">
                                <button
                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                    type="button" id="password-addon">
                                    <i class="ri-eye-fill align-middle" id="toggle-password-icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="password-confirmation">Confirmar Contraseña</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control pe-5"
                                    placeholder="Confirmar Contraseña" id="password-confirmation" name="password_confirmation">
                                <button
                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                    type="button" id="password-confirmation-addon">
                                    <i class="ri-eye-fill align-middle" id="toggle-password-confirmation-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="address" class="form-labe">Dirección:</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Ingrese Dirección">
                        </div>
                        <div class="col-md-6">
                            <label for="image" class="form-labe">Imagen</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="Selecciones imagen">

                        </div>
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

<script>
    // NIT
    document.getElementById('enable_nit').addEventListener('change', function () {
        const nitField = document.getElementById('nit');
        const ciField = document.getElementById('ci');

        if (this.checked) {
            // Habilitar el campo NIT y llenar con el valor de CI (sin sufijo automático)
            nitField.disabled = false;
            nitField.value = ciField.value ? ciField.value : ""; // Solo el CI, sin sufijo
        } else {
            // Deshabilitar el campo NIT y vaciar su valor
            nitField.disabled = true;
            nitField.value = "";
        }
    });

    // Actualizar el campo NIT dinámicamente al cambiar el valor del CI
    document.getElementById('ci').addEventListener('input', function () {
        const enableNit = document.getElementById('enable_nit');
        const nitField = document.getElementById('nit');

        if (enableNit.checked) {
            nitField.value = this.value ? this.value : ""; // Solo copiar el CI, sin sufijo automático
        }
    });

    //Correo electrónico
    // NIT y CI para generar el correo electrónico
    document.getElementById('enable_nit').addEventListener('change', function () {
        const nitField = document.getElementById('nit');
        const ciField = document.getElementById('ci');
        const emailField = document.getElementById('email');

        if (this.checked) {
            // Si NIT está habilitado, usar NIT en el correo
            emailField.value = `JPM.${nitField.value}@Outlook.com`;
        } else {
            // Si NIT no está habilitado, usar CI en el correo
            emailField.value = `JPM.${ciField.value}@Outlook.com`;
        }
    });

    // Actualizar el correo cuando se cambie el valor de CI
    document.getElementById('ci').addEventListener('input', function () {
        const enableNit = document.getElementById('enable_nit');
        const ciField = document.getElementById('ci');
        const nitField = document.getElementById('nit');
        const emailField = document.getElementById('email');

        if (enableNit.checked) {
            emailField.value = `JPM.${nitField.value}@Outlook.com`; // Si el NIT está habilitado
        } else {
            emailField.value = `JPM.${ciField.value}@Outlook.com`; // Si el NIT no está habilitado
        }
    });

    // Actualizar el correo cuando se cambie el valor de NIT
    document.getElementById('nit').addEventListener('input', function () {
        const enableNit = document.getElementById('enable_nit');
        const ciField = document.getElementById('ci');
        const nitField = document.getElementById('nit');
        const emailField = document.getElementById('email');

        if (enableNit.checked) {
            emailField.value = `JPM.${nitField.value}@Outlook.com`; // Si el NIT está habilitado
        } else {
            emailField.value = `JPM.${ciField.value}@Outlook.com`; // Si el NIT no está habilitado
        }
    });



    // Contraseña
    function togglePasswordVisibility(inputId, iconId) {
        const inputField = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.remove('ri-eye-fill');
            icon.classList.add('ri-eye-off-fill');
        } else {
            inputField.type = 'password';
            icon.classList.remove('ri-eye-off-fill');
            icon.classList.add('ri-eye-fill');
        }
    }

    document.getElementById('password-addon').addEventListener('click', function () {
        togglePasswordVisibility('password-input', 'toggle-password-icon');
    });

    document.getElementById('password-confirmation-addon').addEventListener('click', function () {
        togglePasswordVisibility('password-confirmation', 'toggle-password-confirmation-icon');
    });


</script>
