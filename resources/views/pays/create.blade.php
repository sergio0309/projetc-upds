<div class="modal fade" id="pagarServicio-{{$service->id}}" tabindex="-1" aria-labelledby="pagarServicioLabel-{{$service->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pagarServicioLabel-{{$service->id}}">Seleccionar Plan de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pays.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="service_record_id" value="{{ $service->id }}">
                    <input type="hidden" name="status" value="1">
                    <div class="row mb-3">
                        <div class="col-md-9">
                            <label class="form-label">Tipo de Servicio</label>
                            @if(isset($service->type_service))
                                <input type="text" class="form-control" value="{{ $service->type_service->name }}" readonly>
                            @else
                                <input type="text" class="form-control" value="Sin tipo de servicio" readonly>
                            @endif

                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Deuda Total</label>
                            <input type="text" class="form-control" value="{{ number_format($service->amount, 0, '.', ',') }} Bs" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="plant_pay_id" class="form-label">Seleccionar Plan de Pago</label>
                        <select class="form-select" name="plant_pay_id" id="plant_pay_id-{{$service->id}}" required>
                            <option value="">Selecciona un plan</option>
                            @foreach ($plants_pay as $plan)
                                <option value="{{ $plan->id }}" data-image="{{ asset('storage/'.$plan->image) }}" data-name="{{ $plan->name }}">
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Mostrar la imagen del plan seleccionado -->
                    <div id="payment-plan-image-{{$service->id}}" class="mb-3 d-flex justify-content-center" style="display: none;">
                        <img src="" alt="Imagen del plan" id="plan-image-{{$service->id}}" class="img-fluid rounded shadow-sm" style="max-height: 350px; width: auto;">
                    </div>

                    <div class="mb-3">
                        <label for="pay" class="form-label">Pago</label>
                        <input type="number" class="form-control" name="pay" id="pay-{{$service->id}}" placeholder="Monto a pagar" required>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Subir Archivo</label>
                        <input type="file" class="form-control" name="file" id="file-{{$service->id}}" accept="image/*,application/pdf">
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Pagar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('select[name="plant_pay_id"]').forEach(select => {
            select.addEventListener('change', function () {
                const serviceId = this.id.split('-')[1];
                const imageContainer = document.getElementById('payment-plan-image-' + serviceId);
                const planImage = document.getElementById('plan-image-' + serviceId);

                const selectedOption = this.options[this.selectedIndex];
                const imageUrl = selectedOption.getAttribute('data-image');

                console.log("Seleccionado:", selectedOption.textContent, "URL:", imageUrl); // Depuración

                if (imageUrl && imageUrl !== "null") {
                    planImage.src = imageUrl;
                    imageContainer.style.display = 'block';
                } else {
                    imageContainer.style.display = 'none';
                    planImage.src = '';
                }
            });
        });
    });

</script>
