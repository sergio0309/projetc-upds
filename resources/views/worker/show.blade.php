
<div class="modal fade bs-example-modal-sm" id="verWorker-{{ $worker->user->id }}" tabindex="-1" aria-labelledby="verWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="verWorkerModalLabel">Ver Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-3 d-flex justify-content-center">
                            <!-- Imagen de perfil -->
                            <div class="profile-user position-relative d-inline-block">
                                @if(file_exists(public_path('storage/'.$worker->user->image)))
                                    <img src="{{ asset('storage/'.$worker->user->image ) }}"
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
                                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $worker->user->first_name }}" disabled/>
                                </div>
                                <div class="col-md-4">
                                    <label for="last_name" class="form-label">Apellidos</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $worker->user->last_name }}" disabled/>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Género</label>
                                    <input type="text" id="gender" name="gender" class="form-control" value="{{ $worker->user->gender }}" disabled/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="ci" class="form-label">Cédula de Identidad</label>
                                    @if ($worker->user->complement_ci)
                                        <input disabled
                                            value="{{ $worker->user->ci }} - {{ $worker->user->complement_ci }}"
                                            type="text"
                                            name="ci"
                                            class="form-control"
                                        />
                                    @else
                                        <input type="text" class="form-control" value="{{ $worker->user->ci }}" disabled>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="enable_nit" class="form-label">NIT</label>
                                    <input
                                        value="{{ $worker->user->nit }}"
                                        type="number"
                                        id="nit-{{ $worker->user->id }}"
                                        name="nit"
                                        class="form-control"
                                        placeholder="NIT"
                                        {{ $worker->user->nit ? '' : 'disabled' }}
                                        oninput="syncNitWithCi({{ $worker->user->id }})"
                                        disabled
                                    />
                                </div>
                                <div class="col-md-3">
                                    <label for="date_birth" class="form-label">Fecha de Nacimiento</label>
                                    <input value="{{ $worker->user->date_birth }}" type="date" id="date_birth" name="date_birth" class="form-control" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">Número de Celular</label>
                                    <input value="{{ $worker->user->phone }}" type="text" id="phone" name="phone" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="email-field" class="form-label">Correo electrónico</label>
                            <input value="{{ $worker->user->email }}" type="email" id="email" name="email" class="form-control" disabled/>
                        </div>
                        <div class="col-md-5">
                            <label for="profession" class="form-label">Profesión</label>
                            <input type="text" id="profession" name="profession" class="form-control" value="{{ $worker->profession }}" disabled/>
                        </div>

                        <div class="col-md-2">
                            <label for="marital_status" class="form-label">Estado</label>
                            <input type="text" class="form-control" value="{{ $worker->marital_status }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="emergency_contact" class="form-label">Contacto de emergencia</label>
                            <input value="{{ $worker->user->emergency_contact }}" type="text" name="emergency_contact" id="emergency_contact" class="form-control" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="emergency_number" class="form-label">Número de contacto</label>
                            <input value="{{ $worker->user->emergency_number }}" type="number" name="emergency_number" id="emergency_number" class="form-control" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="address" class="form-labe">Dirección:</label>
                            <input value="{{ $worker->user->address }}" type="text" class="form-control" id="address" name="address" disabled>
                        </div>
                    </div>
                    <div class="row mb-3 border mt-3 border-dashed">
                        <div class="col-md-12">
                            <label for="roles">Roles</label>
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-md-4">
                                        <input disabled
                                            type="checkbox"
                                            id="role-{{ $role->id }}"
                                            name="roles[]"
                                            value="{{ $role->id }}"
                                            class="form-check-input"
                                            {{ $worker->user->roles->contains($role->id) ? 'checked' : '' }}>
                                        <label for="role-{{ $role->id }}" class="form-check-label">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
