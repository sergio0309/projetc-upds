<div class="modal fade bs-example-modal-sm" id="verUser-{{$user->id}}" tabindex="-1" aria-labelledby="verUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="#" method="#" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-5 d-flex justify-content-center">
                            <!-- Imagen de perfil -->
                            <div class="profile-user position-relative d-inline-block">
                                @if(file_exists(public_path('storage/'.$user->image)))
                                    <img src="{{ asset('storage/'.$user->image ) }}"
                                        class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image" style="width: 180px; height: 180px;">
                                @else
                                    <img src="{{ asset('assets/images/users/deafult-user.jpg') }}"
                                    class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image" style="width: 180px; height: 180px;">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="first_name" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" value="{{ $user->first_name }} {{ $user->last_name }}" disabled />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ci" class="form-label">Cédula de Identidad</label>
                                    @if ( $user->complement_ci )
                                        <input type="text" class="form-control" value="{{ $user->ci }}-{{ $user->complement_ci}}" disabled />
                                    @else
                                        <input type="text" class="form-control" value="{{ $user->ci }}" disabled />
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="nit" class="form-label">NIT</label>
                                    @if ( $user->nit )
                                        <input type="text" class="form-control" value="{{ $user->nit }}" disabled />
                                    @else
                                        <input type="text" class="form-control" value="NO EXISTE" disabled style="opacity: 0.5;"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="date_birth" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" id="date_birth" name="date_birth" class="form-control" value="{{ $user->date_birth }}" disabled />
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Género</label>
                            <select id="gender" name="gender" class="form-control" disabled>
                                <option value="Masculino" {{ $user->gender == 'MASCULINO' ? 'selected' : '' }}>MASCULINO</option>
                                <option value="Femenino" {{ $user->gender == 'FEMENINO' ? 'selected' : '' }}>FEMENINO</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="phone" class="form-label">Número de Celular</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}" disabled />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email-field" class="form-label">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" disabled />
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" id="address" name="address" class="form-control" value="{{ $user->address }}" disabled />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="emergency_contact" class="form-label">Contacto de emergencia</label>
                            <input type="text" name="emergency_contact" id="emergency_contact" value="{{ $user->emergency_contact }}" class="form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="emergency_number" class="form-label">Número de contacto</label>
                            <input type="number" name="emergency_number" id="emergency_number" value="{{ $user->emergency_number }}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
