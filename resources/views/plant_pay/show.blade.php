<div class="modal fade" id="verPlan-{{$plant->id}}" tabindex="-1" aria-labelledby="verPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title" id="verPlanModalLabel">
                    <i class="bi bi-eye text-secondary"></i> Detalles del Plan de Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <!-- Estado -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Estado del Plan</label>
                        <span class="badge {{ $plant->status ? 'badge-soft-success' : 'badge-soft-danger' }} text-uppercase">
                            {{ $plant->status ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>

                    <!-- Nombre -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nombre del Plan</label>
                        <input type="text" class="form-control" value="{{ $plant->name ?? 'N/A' }}" readonly>
                    </div>

                    <!-- Imagen -->
                    <div class="col-md-12 mb-3 text-center">
                        <label class="form-label">Imagen</label>
                        <div class="mt-3">
                            @if(!empty($plant->image) && Storage::disk('public')->exists($plant->image))
                                <img src="{{ asset('storage/'.$plant->image) }}" alt="Imagen del Plan" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                            @else
                                <p class="text-muted">No hay imagen disponible</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
