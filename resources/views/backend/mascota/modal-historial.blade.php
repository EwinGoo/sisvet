<div class="modal fade" id="modal-historial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="modal-title">Historial</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1">
                <form id="form-historial" target="_blank" action="{{ route('admin-mascota.historial-clinico') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" id="input-mascota-id" name="id_mascota" value="">
                    <button id="new-historial" class="btn bg-gradient-primary btn-sm my-3">+ Nuevo historial</button>
                </form>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Fecha y hora
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    estado
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    accion
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['historiales'] as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <h6 class="mb-0 font-weight-normal text-sm">
                                                {{ $item->created_at }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">
                                            <span
                                                class="badge badge-{{ $item->estado == '1' ? 'warning' : 'success' }}">
                                                {{ $item->estado == '1' ? 'ACTIVO' : 'COMPLETADO' }}
                                            </span>
                                        </p>
                                    </td>
                                    <td>
                                        <a data-id="${id}" class="btn btn-sm btn-info m-0" data-bs-toggle="tooltip"
                                            data-bs-original-title="Historial ${name}" target='_blank'>
                                            <i class="material-icons position-relative text-lg">visibility</i> revisar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn-cancel" type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal"><i
                        class="material-icons">close</i> Cancelar</button>
                <button id="btn-submit" type="button" class="btn bg-gradient-primary "><i
                        class="material-icons">done</i> Guardar</button>
            </div>
        </div>
    </div>
</div>
