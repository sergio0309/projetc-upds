<div class="modal fade" id="editarPlan-{{$plant->id}}" tabindex="-1" aria-labelledby="editarPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Cabecera -->
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title" id="editarPlanModalLabel">
                    <i class="bi bi-pencil-square text-secondary"></i> Editar Plan de Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('plant_pay.update', $plant->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-12 mb-3">
                            <label for="name-{{$plant->id}}" class="form-label">Nombre del Plan</label>
                            <input type="text" id="name-{{$plant->id}}" name="name" class="form-control" value="{{ $plant->name }}" required>
                        </div>

                        <!-- Imagen -->
                        <div class="col-md-12 mb-3 text-center">
                            <label for="image-{{$plant->id}}" class="form-label">Imagen (Opcional)</label>
                            <input type="file" id="image-{{$plant->id}}" name="image" class="form-control" accept="image/*" onchange="previewEditImage(event, {{$plant->id}})">

                            <div class="mt-3">
                                @if(!empty($plant->image) && Storage::disk('public')->exists($plant->image))
                                    <img id="preview-{{$plant->id}}" src="{{ asset('storage/'.$plant->image) }}" alt="Imagen del Plan" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                @else
                                    <p class="text-muted">No hay imagen disponible</p>
                                    <img id="preview-{{$plant->id}}" src="" alt="Previsualización" class="img-fluid rounded shadow-sm d-none" style="max-height: 300px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer con botones centrados -->
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewEditImage(event, id) {
        const preview = document.getElementById('preview-' + id);
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
