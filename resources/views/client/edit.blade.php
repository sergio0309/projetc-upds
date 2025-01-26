
<div class="modal fade bs-example-modal-sm" id="editClient-{{ $client->user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="editUserModalLabel">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="{{ route('clients.update', $client->user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="row mb-4">
                        <div class="col-md-3 d-flex justify-content-center">
                            <!-- Imagen de perfil -->
                            <div class="profile-user position-relative d-inline-block">
                                @if(file_exists(public_path('storage/'.$client->user->image)))
                                    <img src="{{ asset('storage/'.$client->user->image ) }}"
                                        class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image" style="width: 180px; height: 180px;">
                                @else
                                    <img src="{{ asset('assets/images/users/deafult-user.jpg') }}"
                                    class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image" style="width: 180px; height: 180px;">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="first_name" class="form-label">Nombres</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $client->user->first_name }}" placeholder="Ingresar Nombre"/>
                                </div>
                                <div class="col-md-4">
                                    <label for="last_name" class="form-label">Apellidos</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $client->user->last_name }}" placeholder="Ingrese Apellido"/>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Género</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="" disabled>Seleccione género</option>
                                        <option value="Masculino" {{ $client->user->gender == 'MASCULINO' ? 'selected' : '' }}>MASCULINO</option>
                                        <option value="Femenino" {{ $client->user->gender == 'FEMENINO' ? 'selected' : '' }}>FEMENINO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="ci" class="form-label">Cédula de Identidad</label>
                                    <input
                                        value="{{ $client->user->ci }}"
                                        type="text"
                                        id="ci-{{ $client->user->id }}"
                                        name="ci"
                                        class="form-control"
                                        placeholder="Ingresar CI"
                                        required
                                        oninput="syncCiWithNit({{ $client->user->id }})"
                                    />
                                </div>

                                <div class="col-md-3">
                                    <label for="complement_ci" class="form-label">Complemento CI</label>
                                    <input value="{{ $client->user->complement_ci }}" type="text" id="complement_ci" name="complement_ci" class="form-control" placeholder="Complemento"/>
                                </div>

                                <div class="col-md-3">
                                    <label for="enable_nit" class="form-label">
                                        <input
                                            type="checkbox"
                                            id="enable_nit-{{ $client->user->id }}"
                                            class="form-check-input"
                                            onchange="toggleNitField({{ $client->user->id }})"
                                            {{ $client->user->nit ? 'checked' : '' }}
                                        />
                                        NIT
                                    </label>
                                    <input
                                        value="{{ $client->user->nit }}"
                                        type="number"
                                        id="nit-{{ $client->user->id }}"
                                        name="nit"
                                        class="form-control"
                                        placeholder="NIT"
                                        {{ $client->user->nit ? '' : 'disabled' }}
                                        oninput="syncNitWithCi({{ $client->user->id }})"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <label for="deadline" class="form-label">Fecha limite de pago</label>
                                    <input value="{{ $client->deadline }}" type="number" id="deadline" name="deadline" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="date_birth" class="form-label">Fecha de Nacimiento</label>
                            <input value="{{ $client->user->date_birth }}" type="date" id="date_birth" name="date_birth" class="form-control" placeholder="Ingrese Fecha de nacimiento">
                        </div>

                        <div class="col-md-3">
                            <label for="phone" class="form-label">Número de Celular</label>
                            <input value="{{ $client->user->phone }}" type="text" id="phone" name="phone" class="form-control" placeholder="Ingrese número de teléfono">
                        </div>
                        <div class="col-md-6">
                            <label for="email-field" class="form-label">Correo electrónico</label>
                            <input value="{{ $client->user->email }}" type="email" id="email" name="email" class="form-control" placeholder="Ingrese correo electrónico"
                                required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email_2" class="form-labe">2° Correo electrónico</label>
                            <input value="{{ $client->email_2 }}" type="email" class="form-control" id="email_2" name="email_2" placeholder="Ingrese Dirección">
                        </div>
                        <div class="col-md-4">
                            <label for="address" class="form-labe">Dirección:</label>
                            <input value="{{ $client->user->address }}" type="text" class="form-control" id="address" name="address" placeholder="Ingrese Dirección">
                        </div>
                        <div class="col-md-4">
                            <label for="image" class="form-labe">Imagen</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="Selecciones imagen">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="emergency_contact" class="form-label">Contacto de emergencia</label>
                            <input value="{{ $client->user->emergency_contact }}" type="text" name="emergency_contact" id="emergency_contact" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="emergency_number" class="form-label">Número de contacto</label>
                            <input value="{{ $client->user->emergency_number }}" type="number" name="emergency_number" id="emergency_number" class="form-control">
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="changePassword-{{ $client->user->id }}" onclick="togglePasswordFields({{ $client->user->id }})">
                        <label class="form-check-label" for="changePassword-{{ $client->user->id }}">Cambiar contraseña</label>
                    </div>

                    <div id="passwordFields-{{ $client->user->id }}" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="password-input-{{ $client->user->id }}">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password-input-{{ $client->user->id }}" name="password" placeholder="Ingrese nueva contraseña">
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation-{{ $client->user->id }}" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation-{{ $client->user->id }}" name="password_confirmation" placeholder="Confirmar nueva contraseña">
                            </div>
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
    function togglePasswordFields(userId) {
        const passwordFields = document.getElementById(`passwordFields-${userId}`);
        passwordFields.style.display = passwordFields.style.display === 'none' || passwordFields.style.display === '' ? 'block' : 'none';
    }

    function toggleNitField(userId) {
        const nitField = document.getElementById(`nit-${userId}`);
        const enableNitCheckbox = document.getElementById(`enable_nit-${userId}`);
        const ciField = document.getElementById(`ci-${userId}`);
        const emailField = document.getElementById(`email-${userId}`);

        if (enableNitCheckbox.checked) {
            nitField.disabled = false; // Habilitar el campo NIT
            nitField.value = ciField ? ciField.value : ''; // Reflejar el valor del CI en el NIT
            emailField.value = `JPM.${nitField.value}@outlook.com`; // Generar correo basado en NIT
        } else {
            nitField.disabled = true; // Deshabilitar el campo NIT
            nitField.value = ''; // Vaciar el campo NIT
            emailField.value = `JPM.${ciField.value}@outlook.com`; // Generar correo basado en CI
        }
    }

    // Sincronización de NIT con CI no es necesaria, porque NIT no debe afectar a CI
    function syncNitWithCi(userId) {
        const nitField = document.getElementById(`nit-${userId}`);
        const ciField = document.getElementById(`ci-${userId}`);
        const enableNitCheckbox = document.getElementById(`enable_nit-${userId}`);
        const emailField = document.getElementById(`email-${userId}`);

        if (!enableNitCheckbox.checked) {
            // Si el NIT está deshabilitado, sincronizamos el correo con el CI
            emailField.value = `JPM.${ciField.value}@outlook.com`; // Correo basado en CI
        }
    }
</script>
