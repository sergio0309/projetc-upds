<div class="modal fade bs-example-modal-sm" id="nuevoServicio" tabindex="-1" aria-labelledby="nuevoServicioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="nuevoServicioModalLabel">Consulta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <div class="card-body">
                <form action="{{ route('service_records.store') }}" method="POST">
                    @csrf
                    <div>
                        <div class="row">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="client_id" class="form-label">Cliente</label>
                                    <select id="client_id" name="client_id" class="form-control" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->user->first_name }} {{ $client->user->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="type_service_id" class="form-label">Tipo de servicio</label>
                                    <select id="type_service_id" name="type_service_id" class="form-control" required>
                                        <option value="">Seleccione un Servicio</option>
                                        @foreach($services as $service)
                                            @if ($service->status == 1)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="amount">Precio:</label>
                                    <div class="input-group">
                                        <input type="number" name="amount" id="amount" class="form-control" step="1" min="0" required>
                                        <span class="input-group-text">Bs</span>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="description" id="description" placeholder="Ingrese descripción" style="height: 10px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border mt-3 border-dashed"></div>

                    <div class="mt-4 d-flex justify-content-center">
                        <a href="{{ route('service_records.index') }}" class="btn btn-light me-2">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>

                </form><!-- end form -->
            </div>
        </div>
    </div>
</div>


