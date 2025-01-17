
<div class="modal fade" id="createClient" tabindex="-1" aria-labelledby="createClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h4 class="card-title mb-0 flex-grow-1">NUEVO CLIENTE</h4>
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" id="search-ci" placeholder="Buscar por CI"/>
                    <button class="btn btn-outline-secondary" type="button" onclick="searchClientByCI()">
                        <i class="ri-search-line"></i>
                    </button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Contenido del modal -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <input type="number" id="user_id" name="user_id" class="form-control">
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
                                            <option value="MASCULINO">MASCULINO</option>
                                            <option value="FEMENINO">FEMENINO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">

                                    <div class="col-md-3">
                                        <label for="ci" class="form-label">Cédula de Identidad</label>
                                        <input type="number" id="ci" name="ci" class="form-control" placeholder="Ingresar CI" required />
                                    </div>

                                    <div class="col-md-3">
                                        <label for="complement_ci" class="form-label">Complemento CI</label>
                                        <input type="text" id="complement_ci" name="complement_ci" class="form-control" placeholder="Complemento"/>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="enable_nit" class="form-check-label">
                                            <input type="checkbox" id="enable_nit" class="form-check-input" />
                                            NIT
                                        </label>
                                        <input type="number" id="nit" name="nit" class="form-control mt-2" placeholder="Ingresar NIT" disabled />
                                    </div>

                                    <div class="col-md-3">
                                        <label for="deadline" class="form-label">Fecha limite de pago</label>
                                        <input type="number" id="deadline" name="deadline" class="form-control" placeholder="Fecha"/>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email-field" class="form-label">Correo electrónico</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Ingrese correo electrónico" required/>
                                    </div>
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
                                        <label class="form-label" for="password-confirmation">Confirmar</label>
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
                                    <div class="col-md-3">
                                        <label for="date_birth" class="form-label">Fecha de Nacimiento</label>
                                        <input type="date" id="date_birth" name="date_birth" class="form-control" placeholder="Ingrese Fecha de nacimiento" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="phone" class="form-label"> Celular</label>
                                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Ingrese celular" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="email_2" class="form-label">Correo electrónico 2</label>
                                        <input type="email" id="email_2" name="email_2" class="form-control" placeholder="Ingrese correo electrónico" required/>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="rol" class="form-label">Rol</label>
                                        <input type="text" class="form-control" value="CLIENTE" readonly>
                                        <input type="hidden" id="rol" name="rol" value="{{ $roles->firstWhere('name', 'CLIENTE')->id }}">
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="address" class="form-labe">Dirección:</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Ingrese Dirección" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image" class="form-labe">Imagen</label>
                                        <input type="file" class="form-control" id="image" name="image" placeholder="Selecciones imagen">
                                    </div>
                                </div>
                                <div class="border mt-3 border-dashed"></div><br>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="emergency_contact" class="form-label">Contacto de emergencia</label>
                                        <input type="text" name="emergency_contact" id="emergency_contact" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="emergency_number" class="form-label">Número de contacto</label>
                                        <input type="number" name="emergency_number" id="emergency_number" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <a href="javascript:void(0);" class="btn btn-link link-primary fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                <button type="submit" class="btn btn-success ">GUARDAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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


    // Activar/desactivar NIT basado en checkbox
    document.getElementById('enable_nit').addEventListener('change', function () {
        const nitField = document.getElementById('nit');
        nitField.disabled = !this.checked;
        if (this.checked) {
            nitField.focus();
        } else {
            nitField.disabled = true;//
            nitField.value = '';
        }
    });

    //Searcg-CI
    var users = @json($users);
    function searchClientByCI() {
        var ciInput = document.getElementById('search-ci').value; // Obtener el valor del campo CI
        var user = users.find(function(user) {
            return user.ci === ciInput; // Buscar un usuario que coincida con el CI ingresado
        });

        if (user) {
            // Si el usuario es encontrado, llenar los campos correspondientes en el formulario
            document.getElementById('first_name').value = user.first_name;
            document.getElementById('last_name').value = user.last_name;
            document.getElementById('gender').value = user.gender;
            document.getElementById('ci').value = user.ci;
            document.getElementById('complement_ci').value = user.complement_ci;
            document.getElementById('nit').value = user.nit;
            // document.getElementById('deadline').value = user.deadline;
            document.getElementById('email').value = user.email;
            document.getElementById('phone').value = user.phone;
            // document.getElementById('email_2').value = user.email_2;
            document.getElementById('address').value = user.address;
            document.getElementById('emergency_contact').value = user.emergency_contact;
            document.getElementById('emergency_number').value = user.emergency_number;
            document.getElementById('date_birth').value = user.date_birth;
            document.getElementById('user_id').value = user.id

            if (user.nit) {
                document.getElementById('enable_nit').checked = true;
                document.getElementById('nit').value = user.nit;
                document.getElementById('nit').disabled = false;
            } else {
                // Si el usuario no tiene NIT, deshabilitar el checkbox y limpiar el campo
                document.getElementById('enable_nit').checked = false;
                document.getElementById('nit').value = ''; // Limpiar el campo NIT
                document.getElementById('nit').disabled = true;
            }
            // Deshabilitar los campos y eliminar el atributo 'name'
            var inputsToDisable = [
                'first_name', 'last_name', 'gender', 'ci', 'complement_ci', 'nit',
                'email', 'phone', 'address', 'emergency_contact', 'image',
                'emergency_number', 'date_birth', 'password-input', 'password-confirmation'
            ];

            inputsToDisable.forEach(function(inputId) {
                var input = document.getElementById(inputId);
                input.setAttribute('disabled', 'true'); // Deshabilitar el campo
                input.removeAttribute('name'); // Eliminar el atributo name
            });
            // // Si el usuario tiene una imagen asociada, puedes agregarla en el formulario si es necesario
            // if (user.image) {
            //     document.getElementById('image').value = user.image;
            // }

            // // Cambiar el rol a CLIENTE (si es necesario) o lo que corresponda
            // document.getElementById('rol').value = user.role_id; // Asumiendo que el rol es una propiedad del usuario
        } else {
            // Si no se encuentra el usuario
            alert('Usuario no encontrado');
        }
    }
</script>
