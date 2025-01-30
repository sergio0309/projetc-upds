<div class="modal fade bs-example-modal-sm" id="nuevaDeclaracion" tabindex="-1" aria-labelledby="nuevaDeclaracionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="nuevaDeclaracionModalLabel">Declaración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <div class="card-body">
                <form action="{{ route('statements.store') }}" method="POST">
                    @csrf
                    <div>
                        <div class="row">
                            <div class="row mb-3">
                                <div class="col-md-9">
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
                                <div class="col-md-3">
                                    <label for="date" class="form-label">Fecha</label>
                                    <input type="date" id="date" name="date" class="form-control" required/>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="sales" class="form-label">Ventas</label>
                                    <input placeholder="0" type="number" id="sales" name="sales" class="form-control"/>
                                </div>

                                <div class="col-md-3">
                                    <label for="discounts" class="form-label">Descuentos</label>
                                    <input placeholder="0" type="number" id="discounts" name="discounts" class="form-control"/>
                                </div>

                                <div class="col-md-3">
                                    <label for="purchases" class="form-label">Compras</label>
                                    <input placeholder="0" type="number" id="purchases" name="purchases" class="form-control"/>
                                </div>

                                <div class="col-md-3">
                                    <label for="recorded_purchases" class="form-label">Compras Grabadas</label>
                                    <input placeholder="0" type="number" id="recorded_purchases" name="recorded_purchases" class="form-control"/>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="previous_balance" class="form-label">Saldo Anterior</label>
                                    <input placeholder="0" type="number" id="previous_balance" name="previous_balance" class="form-control"/>
                                </div>

                                <div class="col-md-3">
                                    <label for="update" class="form-label">Actualización</label>
                                    <input placeholder="0" type="number" id="update" name="update" class="form-control"/>
                                </div>

                                <div class="col-md-3">
                                    <label for="current_balance" class="form-label">Saldo Actual</label>
                                    <input placeholder="0" type="number" id="current_balance" name="current_balance" class="form-control"/>
                                </div>

                                <div class="col-md-3">
                                    <label for="calculated_IVA" class="form-label">IVA calculado</label>
                                    <input placeholder="0" type="number" id="calculated_IVA" name="calculated_IVA" class="form-control"/>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="real_IVA" class="form-label">IVA real</label>
                                    <input placeholder="0" type="number" id="real_IVA" name="real_IVA" class="form-control"/>
                                </div>

                                <div class="col-md-2">
                                    <label for="comp_IUE" class="form-label">Comp del IUE</label>
                                    <input placeholder="0" type="number" id="comp_IUE" name="comp_IUE" class="form-control"/>
                                </div>

                                <div class="col-md-2">
                                    <label for="calculated_IT" class="form-label">IT Calculado</label>
                                    <input placeholder="0" type="number" id="calculated_IT" name="calculated_IT" class="form-control"/>
                                </div>

                                <div class="col-md-2">
                                    <label for="real_IT" class="form-label">IT Real</label>
                                    <input placeholder="0" type="number" id="real_IT" name="real_IT" class="form-control"/>
                                </div>

                                <div class="col-md-3">
                                    <label for="IUE" class="form-label">IUE</label>
                                    <input placeholder="0" type="number" id="IUE" name="IUE" class="form-control"/>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="border mt-3 border-dashed"></div>

                    <div class="mt-4 d-flex justify-content-center">
                        <a href="{{ route('statements.index') }}" class="btn btn-light me-2">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>

                </form><!-- end form -->
            </div>
        </div>
    </div>
</div>

<script>
    function calculateRealIVA() {
        const previousBalance = parseFloat(document.getElementById('previous_balance').value) || 0;
        const update = parseFloat(document.getElementById('update').value) || 0;
        const currentBalance = parseFloat(document.getElementById('current_balance').value) || 0;
        const calculatedIVA = parseFloat(document.getElementById('calculated_IVA').value) || 0;

        const realIVA = previousBalance - update - currentBalance - calculatedIVA;

        document.getElementById('real_IVA').value = realIVA.toFixed(2);
    }
    function calculateRealIT() {
        const compIUE = parseFloat(document.getElementById('comp_IUE').value) || 0;
        const calculatedIT = parseFloat(document.getElementById('calculated_IT').value) || 0;

        const realIT = compIUE - calculatedIT;

        document.getElementById('real_IT').value = realIT.toFixed(2); // Muestra el resultado en el campo real_IT
    }
    document.getElementById('previous_balance').addEventListener('input', calculateRealIVA);
    document.getElementById('update').addEventListener('input', calculateRealIVA);
    document.getElementById('current_balance').addEventListener('input', calculateRealIVA);
    document.getElementById('calculated_IVA').addEventListener('input', calculateRealIVA);
    document.getElementById('comp_IUE').addEventListener('input', calculateRealIT);
    document.getElementById('calculated_IT').addEventListener('input', calculateRealIT);
</script>
