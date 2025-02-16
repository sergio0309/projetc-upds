<div class="modal fade" id="crearPlan" tabindex="-1" aria-labelledby="crearPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Cabecera más sobria -->
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title" id="crearPlanModalLabel">
                    <i class="bi bi-card-list text-secondary"></i> Nuevo Plan de Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('plant_pay.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre del Plan</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Ingresar Nombre del Plan" required>
                        </div>

                        <!-- Imagen -->
                        <div class="col-md-12 mb-3 text-center">
                            <label for="image" class="form-label">Imagen (Opcional)</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                            <div class="mt-3">
                                <img id="preview" src="" alt="Previsualización" class="img-fluid rounded shadow-sm d-none" style="max-height: 300px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer con botones centrados -->
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.classList.add('d-none');
        }
    }
</script>
