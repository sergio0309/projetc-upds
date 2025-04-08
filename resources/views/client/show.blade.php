
<div class="modal fade bs-example-modal-sm" id="verClient-{{ $client->user->id }}" tabindex="-1"
    aria-labelledby="verClientModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
       <div class="modal-content">
           <div class="modal-header bg-light p-3">
               <h5 class="modal-title" id="verClientModalLabel">Ver Cliente</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
           </div>
           <form>
            <div class="modal-body">

                <div class="row mb-4">
                    <div class="col-md-3 d-flex justify-content-center">
                        <!-- Imagen de perfil -->
                        <div class="profile-user position-relative d-inline-block">
                            @if(file_exists(public_path('storage/'.$client->user->image)))
                                <img src="{{ asset('storage/'.$client->user->image ) }}"
                                    class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image" style="width: 180px; height: 180px;">
                            @else
                                <img src="{{ asset('assets/images/users/user-dummy-img.jpg') }}"
                                class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image" style="width: 180px; height: 180px;">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="first_name" class="form-label">Nombres</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $client->user->first_name }}" disabled/>
                            </div>
                            <div class="col-md-4">
                                <label for="last_name" class="form-label">Apellidos</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $client->user->last_name }}" disabled/>
                            </div>
                            <div class="col-md-4">
                                <label for="gender" class="form-label">Género</label>
                                <input type="text" id="gender" name="gender" class="form-control" value="{{ $client->user->gender }}" disabled/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="ci" class="form-label">Cédula de Identidad</label>
                                @if ($client->user->complement_ci)
                                    <input
                                        value="{{ $client->user->ci }} - {{ $client->user->complement_ci }}"
                                        type="text"
                                        id="ci-{{ $client->user->id }}"
                                        name="ci"
                                        class="form-control"
                                        placeholder="Ingresar CI"
                                        disabled
                                        oninput="syncCiWithNit({{ $client->user->id }})"
                                    />
                                @else
                                    <input
                                        value="{{ $client->user->ci }}"
                                        type="text"
                                        id="ci-{{ $client->user->id }}"
                                        name="ci"
                                        class="form-control"
                                        placeholder="Ingresar CI"
                                        disabled
                                        oninput="syncCiWithNit({{ $client->user->id }})"
                                    />
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label for="enable_nit" class="form-label">NIT</label>
                                <input
                                    value="{{ $client->user->nit ?? 'N/A' }}"
                                    type="text"
                                    id="nit-{{ $client->user->id }}"
                                    name="nit"
                                    class="form-control"
                                    disabled
                                />
                            </div>
                            <div class="col-md-3">
                                <label for="deadline" class="form-label">Fecha limite de pago</label>
                                <input value="{{ $client->deadline }}" type="number" id="deadline" name="deadline" class="form-control"disabled/>
                            </div>
                            <div class="col-md-3">
                                <label for="date_birth" class="form-label">Fecha de Nacimiento</label>
                                <input value="{{ $client->user->date_birth }}" type="date" id="date_birth" name="date_birth" class="form-control" disabled/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="phone" class="form-label">Número de Celular</label>
                        <input value="{{ $client->user->phone }}" type="text" id="phone" name="phone" class="form-control" disabled/>
                    </div>
                    <div class="col-md-5">
                        <label for="email-field" class="form-label">Correo electrónico</label>
                        <input value="{{ $client->user->email }}" type="email" id="email" name="email" class="form-control" disabled/>
                    </div>
                    {{-- <div class="col-md-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input value="{{ $client->user->password }}" type="password" id="password" name="password" class="form-control" disabled/>
                    </div> --}}
                    <div class="col-md-5">
                        <label for="email_2" class="form-labe">2° Correo electrónico</label>
                        <input value="{{ $client->email_2 }}" type="email" class="form-control" id="email_2" name="email_2" disabled/>
                    </div>
                    {{-- <div class="col-md-3">
                        <label for="password_2" class="form-label">2° Contraseña</label>
                        <input value="{{ $client->password_2 }}" type="password_2" id="password_2" name="password_2" class="form-control" disabled/>
                    </div> --}}
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="emergency_contact" class="form-label">Contacto de emergencia</label>
                        <input value="{{ $client->user->emergency_contact }}" type="text" name="emergency_contact" id="emergency_contact" class="form-control" disabled/>
                    </div>
                    <div class="col-md-4">
                        <label for="emergency_number" class="form-label">Número de contacto</label>
                        <input value="{{ $client->user->emergency_number }}" type="number" name="emergency_number" id="emergency_number" class="form-control" disabled/>
                    </div>
                    <div class="col-md-4">
                        <label for="address" class="form-labe">Dirección:</label>
                        <input value="{{ $client->user->address }}" type="text" class="form-control" id="address" name="address" disabled/>
                    </div>
                </div>
                @php
                    $filteredServices = $client->serviceRecords->filter(function ($service) {
                        return $service->status === 0 || $service->status === 1;
                    });
                @endphp
                @if ($filteredServices->isNotEmpty())
                <div class="row mb-3">
                    <div class="col-md-2">
                        <strong class="form-label">N°</strong>
                    </div>
                    <div class="col-md-4">
                        <strong class="form-label">Servicio</strong>
                    </div>
                    <div class="col-md-3">
                        <strong class="form-label">Monto</strong>
                    </div>
                    <div class="col-md-3">
                        <strong class="form-label">Estado</strong>
                    </div>
                    {{-- <div class="col-md-3">
                        <strong class="form-label">Acción</strong>
                    </div> --}}
                </div>

                @php $number = 1; @endphp
                @foreach ($filteredServices as $service)
                    <hr>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-2">
                            <span class="h6">{{ $number++ }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="h6">
                                {{ $service->statement ? 'DECLARACIÓN' : ($service->type_service?->name ?? 'Sin tipo de servicio') }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <span class="h6">{{ $service->amount }} Bs.</span>
                        </div>
                        <div class="col-md-3">
                            @if ($service->status === 0)
                                <span class="badge badge-soft-danger text-uppercase fs-6">DEUDA</span>
                            @elseif ($service->status === 1)
                                <span class="badge badge-soft-warning text-uppercase fs-6">PENDIENTE</span>
                            @endif
                        </div>
                        {{-- <div class="col-md-3">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-money-bill-wave"></i> Pagar
                            </button>
                        </div> --}}
                    </div>
                    <hr>
                @endforeach
            @endif
            </div>
        </form>
        </div>
    </div>
</div>
