@extends('backend.app')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-lg-flex">
                <div>
                    <h5 class="mb-0">Backups de la Base de Datos</h5>
                    <p class="text-sm mb-0">
                        Listado de archivos de respaldo generados.
                    </p>
                </div>
                <div class="ms-auto my-auto mt-lg-0 mt-4">
                    <a href="{{ route('admin-db.generate') }}" class="btn btn-primary btn-sm mb-0">Generar Backup</a>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-0" style='min-height: 25rem;'>
            <div class="table-responsive">
                <table class="table table-flush" style="width:100%" id="datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>N°</th>
                            <th>Nombre Archivo</th>
                            <th>Fecha Creación</th>
                            <th>Tamaño (KB)</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @forelse($data['backups'] as $backup)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $backup['name'] }}</td>
                            <td>{{ $backup['date'] }}</td>
                            <td>{{ $backup['size'] }}</td>
                            <td>
                                <a href="{{ route('admin-db.download', $backup['name']) }}" class="btn btn-success btn-sm" target="_blank">
                                    Descargar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">No se encontraron backups.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
