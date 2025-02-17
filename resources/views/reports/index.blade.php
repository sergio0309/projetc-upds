@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        {{-- @can('crear-archivo') --}}
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ route('reports.anual_pdf', ['id' => $client->id]) }}" class="btn btn-success add-btn">
                                    <i data-feather="plus" class="align-bottom me-1"></i> Reporte anual
                                </a>
                            </div>
                        </div>

                        {{-- @endcan --}}
                    </div>
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($serviceRecords as $service)
                                    @if ( $service->statement_id )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $service->description }}</td>
                                            <td>
                                                {{ strtoupper(\Carbon\Carbon::parse($service->date)->translatedFormat('d \d\e F \d\e Y')) }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <!-- Botón para ver el archivo PDF -->
                                                    {{-- <button title="Ver" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#verPDF-{{$service->statement_id}}" data-pdf-url="{{ route('reports.pdf', ['id' => $service->statement_id]) }}">
                                                        <i class="ri-eye-line"></i> <!-- Ícono de ojo -->
                                                    </button> --}}

                                                    {{-- @can('editar-archivo') --}}
                                                    <div class="col-sm-auto">
                                                        <a href="{{ route('reports.pdf', ['id' => $service->statement_id]) }}" title="Descargar archivo" class="btn btn-sm btn-success">
                                                            <i class="ri-download-line"></i> <!-- Ícono de descarga -->
                                                        </a>
                                                    </div>
                                                    {{-- @endcan --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
