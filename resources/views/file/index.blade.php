@extends('layouts.app')
@include('file.create')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#uploadFile">
                                    <i class="ri-add-line align-bottom me-1"></i> Subir Documento
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="sort">#</th>
                                    <th class="sort">Fecha</th>
                                    <th class="sort">Vista previa</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($files as $file)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="customer_name">
                                        {{ strtoupper(\Carbon\Carbon::parse($file->data)->translatedFormat('d \d\e F \d\e Y')) }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <div>
                                                <button
                                                    title="Ver"
                                                    class="btn btn-sm btn-primary view-file-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewFileModal"
                                                    data-file-url="{{ $file->file_url }}"
                                                    data-file-type="{{ $file->file_type }}">
                                                    <i data-feather="eye"></i>
                                                </button>
                                            </div>
                                            {{-- <div>
                                                <button
                                                    title="Editar"
                                                    class="btn btn-sm btn-warning edit-item-btn">
                                                    <i data-feather="edit-3"></i>
                                                </button>
                                            </div> --}}
                                            <div>
                                                <button
                                                    title="Reemplazar archivo"
                                                    class="btn btn-sm btn-warning edit-item-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editFileModal"
                                                    data-file-id="{{ $file->id }}">
                                                    <i data-feather="edit-3"></i>
                                                </button>
                                            </div>
                                            <div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editFileModalLabel">Reemplazar Archivo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="editFileForm" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <input type="hidden" id="fileId" name="id">
                                                                <div class="mb-3">
                                                                    <label for="fileInput" class="form-label">Nuevo Archivo</label>
                                                                    <input type="file" class="form-control" id="fileInput" name="file" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Reemplazar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <a href="{{ route('files.download', $file->id) }}"
                                                   title="Descargar archivo"
                                                   class="btn btn-sm btn-success">
                                                    <i data-feather="download"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal" data-bs-target="#confirmarModal-{{ $file->id }}">
                                                    <i data-feather="delete"></i>
                                                </button>
                                            </div>
                                            <div class="modal fade" id="confirmarModal-{{ $file->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $file->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel-{{ $file->id }}">Mensaje de Confirmación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas eliminar este archivo?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <!-- Formulario dentro del modal -->
                                                            <form action="{{ route('files.destroy', $file->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Confirmar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para vista previa -->
<div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFileModalLabel">Vista previa del archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="filePreview">
                    <!-- Aquí se cargará la vista previa -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Selecciona todos los botones de vista previa
        const viewFileButtons = document.querySelectorAll('.view-file-btn');
        const previewContainer = document.getElementById('filePreview');
        const modal = new bootstrap.Modal(document.getElementById('viewFileModal'));

        // Limpia el contenido del modal cuando se cierra
        document.getElementById('viewFileModal').addEventListener('hidden.bs.modal', function () {
            previewContainer.innerHTML = '';
        });

        // Agrega evento de clic a cada botón
        viewFileButtons.forEach(button => {
            button.addEventListener('click', function () {
                const fileUrl = this.getAttribute('data-file-url');
                const fileType = this.getAttribute('data-file-type');

                // Limpia el contenido previo
                previewContainer.innerHTML = '';

                // Carga la vista previa según el tipo de archivo
                if (fileType === 'application/pdf') {
                    previewContainer.innerHTML = `<iframe src="${fileUrl}" style="width:100%; height:500px;" frameborder="0"></iframe>`;
                } else if (fileType.startsWith('image/')) {
                    previewContainer.innerHTML = `<img src="${fileUrl}" style="width:100%; max-height:500px;" alt="Vista previa de la imagen">`;
                } else {
                    previewContainer.innerHTML = `<p>No se puede mostrar una vista previa para este tipo de archivo.</p>`;
                }

                // Muestra el modal
                modal.show();
            });
        });

        // Reemplaza íconos con Feather (cargado una sola vez)
        feather.replace();
    });

    // Editar archivo
    document.addEventListener('DOMContentLoaded', () => {
        const editFileModal = document.getElementById('editFileModal');
        const editFileForm = document.getElementById('editFileForm');

        editFileModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget; // Botón que disparó el modal
            const fileId = button.getAttribute('data-file-id');

            // Actualizar la acción del formulario con el ID del archivo
            editFileForm.action = `/files/${fileId}`;
        });
    });

</script>
@endsection
