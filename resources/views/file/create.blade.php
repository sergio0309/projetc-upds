<div class="modal fade" id="uploadFile" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h4 class="card-title mb-0 flex-grow-1">Carga de Archivos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ route('files.store') }}" id="uploadForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <label for="files" class="form-label">Subir Archivos de formato PDF:</label>
                                    <input type="file" id="files" name="files[]" multiple class="form-control">
                                    <ul id="fileList" class="mt-3 list-group"></ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Subir Archivos</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const selectedFiles = [];

    document.getElementById('files').addEventListener('change', function (event) {
        const newFiles = Array.from(event.target.files);
        newFiles.forEach((file) => {
            if (!selectedFiles.some((f) => f.name === file.name)) {
                selectedFiles.push(file);
            }
        });
        updateFileList();
    });

    function updateFileList() {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = ''; // Limpiar lista

        selectedFiles.forEach((file, index) => {
            const listItem = document.createElement('li');
            listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

            // Convertir el tamaño a KB o MB
            const fileSize = (file.size / 1024).toFixed(2); // Convertir a KB
            const sizeText = fileSize >= 1024
                ? `${(fileSize / 1024).toFixed(2)} MB`
                : `${fileSize} KB`;

            listItem.textContent = `${file.name} (${sizeText})`;

            const deleteButton = document.createElement('button');
            deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
            deleteButton.textContent = 'Eliminar';
            deleteButton.addEventListener('click', () => {
                selectedFiles.splice(index, 1);
                updateFileList();
            });

            listItem.appendChild(deleteButton);
            fileList.appendChild(listItem);
        });

        if (selectedFiles.length === 0) {
            const noFilesItem = document.createElement('li');
            noFilesItem.textContent = 'No se seleccionaron archivos.';
            noFilesItem.classList.add('list-group-item', 'text-muted');
            fileList.appendChild(noFilesItem);
        }
    }
</script>
