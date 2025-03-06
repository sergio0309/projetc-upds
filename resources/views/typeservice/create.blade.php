<div class="modal fade bs-example-modal-sm" id="crearServicio" tabindex="-1" aria-labelledby="crearServicioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content ">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="editUserModalLabel">Nuevo Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form action="{{ route('typesservice.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Servicio</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Ingresar Nombre del Servicio" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
