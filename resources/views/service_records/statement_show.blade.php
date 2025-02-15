<div class="modal fade bs-example-modal-sm" id="verDeclaracion-{{$service->id}}" tabindex="-1" aria-labelledby="verDeclaracionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="verDeclaracionModalLabel">Ver Declaración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <form>
                    <input type="hidden" id="declaration_id" name="declaration_id">
                    <div class="row mb-3">
                        <div class="col-md-9">
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
                        <div class="col-md-3">
                            <label for="edit_amount">Precio:</label>
                            <div class="input-group">
                                <input value="{{$service->amount}}" type="number" name="amount" id="edit_amount" class="form-control" step="1" min="0" disabled>
                                <span class="input-group-text">Bs</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="sales" class="form-label">Ventas</label>
                            <input value="{{ optional($service->statement)->sales ?? 0 }}" placeholder="0" type="number" id="sales" name="sales" class="form-control" disabled/>
                        </div>

                        <div class="col-md-3">
                            <label for="discounts" class="form-label">Descuentos</label>
                            <input value="{{ optional($service->statement)->discounts ?? 0 }}" placeholder="0" type="number" id="discounts" name="discounts" class="form-control" disabled/>
                        </div>

                        <div class="col-md-3">
                            <label for="purchases" class="form-label">Compras</label>
                            <input value="{{ optional($service->statement)->purchases ?? 0 }}" placeholder="0" type="number" id="purchases" name="purchases" class="form-control" disabled/>
                        </div>

                        <div class="col-md-3">
                            <label for="recorded_purchases" class="form-label">Compras Grabadas</label>
                            <input value="{{ optional($service->statement)->recorded_purchases ?? 0 }}" placeholder="0" type="number" id="recorded_purchases" name="recorded_purchases" class="form-control" disabled/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="previous_balance" class="form-label">Saldo Anterior</label>
                            <input value="{{ optional($service->statement)->previous_balance ?? 0 }}" placeholder="0" type="number" id="previous_balance" name="previous_balance" class="form-control" disabled/>
                        </div>

                        <div class="col-md-3">
                            <label for="update" class="form-label">Actualización</label>
                            <input value="{{ optional($service->statement)->update ?? 0 }}" placeholder="0" type="number" id="update" name="update" class="form-control" disabled/>
                        </div>

                        <div class="col-md-3">
                            <label for="current_balance" class="form-label">Saldo Actual</label>
                            <input value="{{ optional($service->statement)->current_balance ?? 0 }}" placeholder="0" type="number" id="current_balance" name="current_balance" class="form-control" disabled/>
                        </div>

                        <div class="col-md-3">
                            <label for="calculated_IVA" class="form-label">IVA calculado</label>
                            <input value="{{ optional($service->statement)->calculated_IVA ?? 0 }}" placeholder="0" type="number" id="calculated_IVA" name="calculated_IVA" class="form-control" disabled/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="real_IVA" class="form-label">IVA real</label>
                            <input value="{{ optional($service->statement)->real_IVA ?? 0 }}" placeholder="0" type="number" id="real_IVA" name="real_IVA" class="form-control" disabled/>
                        </div>

                        <div class="col-md-2">
                            <label for="comp_IUE" class="form-label">Comp del IUE</label>
                            <input value="{{ optional($service->statement)->comp_IUE ?? 0 }}" placeholder="0" type="number" id="comp_IUE" name="comp_IUE" class="form-control" disabled/>
                        </div>

                        <div class="col-md-2">
                            <label for="calculated_IT" class="form-label">IT Calculado</label>
                            <input value="{{ optional($service->statement)->calculated_IT ?? 0 }}" placeholder="0" type="number" id="calculated_IT" name="calculated_IT" class="form-control" disabled/>
                        </div>

                        <div class="col-md-2">
                            <label for="real_IT" class="form-label">IT Real</label>
                            <input value="{{ optional($service->statement)->real_IT ?? 0 }}" placeholder="0" type="number" id="real_IT" name="real_IT" class="form-control" disabled/>
                        </div>

                        <div class="col-md-3">
                            <label for="IUE" class="form-label">IUE</label>
                            <input value="{{ optional($service->statement)->IUE ?? 0 }}" placeholder="0" type="number" id="IUE" name="IUE" class="form-control" disabled/>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Ingrese descripción" style="height: 10px;" disabled>{{ $service->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border mt-3 border-dashed"></div>
                    <div class="mt-4 d-flex justify-content-center">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
