<!-- Modal Ver Plan -->
<div class="modal fade" id="verPlan-{{$service->id}}" tabindex="-1" aria-labelledby="verPlanLabel-{{$service->id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verPlanLabel-{{$service->id}}">Ver Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Fila con Nombre del Servicio, Fecha y Estado -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Nombre del Servicio</label>
                            <input type="text" class="form-control"
                                value="{{ optional($service->type_service)->name ?? ($service->statement ? 'Declaración' : 'N/A') }}"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha</label>
                            <input type="text" class="form-control" value="{{ strtoupper(\Carbon\Carbon::parse($service->date)->translatedFormat('d \d\e F \d\e Y')) }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <div class="d-flex align-items-center rounded p-2" style="height: 38px;">
                                <span class="badge {{ $service->status == 1 ? 'bg-warning' : 'bg-success' }} w-100 text-center fs-5">
                                    {{ $service->status == 1 ? 'Pendiente' : 'Pagado' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label class="form-label">Descripción del Servicio</label>
                        <textarea class="form-control" rows="1" readonly>{{ $service->description }}</textarea>
                    </div>
                    @if($service->plantsPays->isNotEmpty())
                        @foreach($service->plantsPays as $pay)
                            @if($pay->pivot->file)
                                <div class="mb-3">
                                    <label class="form-label">Archivo Adjuntado</label>
                                    <div class="text-center">
                                        @php
                                            $filePath = asset('storage/' . $pay->pivot->file);
                                            $extension = pathinfo($pay->pivot->file, PATHINFO_EXTENSION);
                                        @endphp

                                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <!-- Mostrar Imagen -->
                                            <img src="{{ $filePath }}" alt="Archivo" class="img-fluid" style="max-width: 100%; height: auto;">
                                            <a href="{{ $filePath }}" download class="btn btn-secondary mt-2">Descargar Imagen</a>

                                        @elseif($extension === 'pdf')
                                            <!-- Mostrar PDF -->
                                            <embed src="{{ $filePath }}" type="application/pdf" width="100%" height="500px" />
                                            <div class="mt-2">
                                                <a href="{{ $filePath }}" target="_blank" class="btn btn-primary">Ver PDF en otra pestaña</a>
                                                <a href="{{ $filePath }}" download class="btn btn-secondary">Descargar PDF</a>
                                            </div>

                                        @else
                                            <p>Archivo no compatible para vista previa.</p>
                                            <a href="{{ $filePath }}" download class="btn btn-secondary">Descargar Archivo</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p>No hay archivos disponibles.</p>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
