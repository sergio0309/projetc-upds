<div class="modal fade bs-example-modal-sm" id="verServicio-{{$service->id}}" tabindex="-1" aria-labelledby="verServicioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="verServicioModalLabel">Detalles del Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="client_id" class="form-label">Cliente</label>
                                <select id="client_id" name="client_id" class="form-control" disabled>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ $service->client_id == $client->id ? 'selected' : '' }}>
                                            {{ $client->user->first_name }} {{ $client->user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="type_service_id" class="form-label">Tipo de servicio</label>
                                <select id="type_service_id" name="type_service_id" class="form-control" disabled>
                                    <option value="">Seleccione un Servicio</option>
                                    @foreach($services as $tipoServicio)
                                        @if ($tipoServicio->status == 1)
                                            <option value="{{ $tipoServicio->id }}"
                                                {{ $service->type_service_id == $tipoServicio->id ? 'selected' : '' }}>
                                                {{ $tipoServicio->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="amount">Precio:</label>
                                <div class="input-group">
                                    <input value="{{ $service->amount }}" type="number" name="amount" id="amount-{{$service->id}}" class="form-control" step="1" min="0" readonly>
                                    <span class="input-group-text">Bs</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" name="description" id="description-{{$service->id}}" rows="1" readonly>{{ $service->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border mt-3 border-dashed"></div>
                    <div class="mt-4 d-flex justify-content-center">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form><!-- end form -->
            </div>
        </div>
    </div>
</div>
