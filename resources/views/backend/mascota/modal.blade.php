{{-- <div class="modal-dialog modal-lg modal-dialog-centered" role="document"> --}}
<div class="modal fade" id="modal-main" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="modal-title">Nueva Mascota</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1">
                @include('backend.mascota.form')
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
<div class="modal fade" id="modal-historial" tabindex="-1" role="dialog" aria-labelledby="modal-historial"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="modal-title">Historial Clínico</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1">
                <div class="col-12 col-md-6 col-xl-12 mt-md-0 mt-4 position-relative">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Reseña del propietario</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-">
                            <div class="row">
                                <div class="col-12 col-md-8 text-sm"><strong class="text-dark">Nombre y
                                        apellidos:</strong> &nbsp; <span id="propietario"></span></div>
                                <div class="col-12 col-md-4 text-sm pt-1"><strong class="text-dark">N° celular:</strong> &nbsp;
                                    <span id="celular"></span>
                                </div>
                                <div class="col-12 col-md-12 text-sm pt-1"><strong class="text-dark">Dirección:</strong>
                                    &nbsp; <span id="direccion"></span></div>
                            </div>
                            <hr class="horizontal dark my-2">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Reseña de la mascota</h6>
                                </div>
                                <table class="table table-flush" id="data-mascota">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-normal text-sm" colspan="2">
                                                <strong class="text-dark">Nombre:</strong> &nbsp;
                                                <span id="nombre_mascota_text"></span>
                                            </td>
                                            <td class="font-weight-normal text-sm" colspan="2">
                                                <strong class="text-dark">Especie:</strong>
                                                &nbsp;
                                                <span id="especie"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-normal text-sm">
                                                <strong class="text-dark">Edad:</strong>
                                                &nbsp; <span id="edad"></span>
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                                <strong class="text-dark">Peso:</strong>
                                                &nbsp; <span id="peso"></span>
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                                <strong class="text-dark">Color:</strong>
                                                &nbsp; <span id="color_text"></span>
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                                <strong class="text-dark">Raza:</strong>
                                                &nbsp; <span id="raza"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="horizontal dark my-2">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Anamnesis</h6>
                                </div>
                            </div>
                            <ul class="list-group" id="data-anamnesis">
                                <li class="list-group-item p-0 border-0 ps-0 text-sm">
                                    <strong class="text-dark">Enfermedadades anteriores:</strong> &nbsp; <span
                                        id="enfermedadades-anteriores"></span>
                                </li>
                                <li class="list-group-item p-0 border-0 ps-0 text-sm">
                                    <strong class="text-dark">Tratamientos recientes:</strong> &nbsp; <span
                                        id="tratamientos-recientes"></span>
                                </li>
                                <li class="list-group-item p-0 border-0 ps-0 text-sm">
                                    <strong class="text-dark">Ultima desparasitación:</strong> &nbsp; <span
                                        id="ultima-desparasitacion"></span>
                                </li>
                                <li class="list-group-item p-0 border-0 ps-0 text-sm">
                                    <strong class="text-dark">Vacunas anteriores:</strong> &nbsp; <span
                                        id="vacunas"></span>
                                </li>
                            </ul>
                            <hr class="horizontal dark my-2">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Examen general</h6>
                                </div>
                                <table class="table table-flush" id="data-examen">
                                    <thead class="thead-light">
                                        <tr class="title-table">
                                            <th class="w-10">fecha</th>
                                            <th>t°</th>
                                            <th>f.c.</th>
                                            <th>f.r.</th>
                                            <th>mucosa</th>
                                            <th>r.c. seg.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark font-weight-bolder text-sm">Inspección</td>
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark font-weight-bolder text-sm">Palpación</td>
                                            <td colspan="5"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="horizontal dark my-2">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Sintomas</h6>
                                </div>
                                <table class="table table-flush" id="data-sintomas">
                                    <thead class="thead-light">
                                        <tr class="title-table">
                                            <th class="w-10">fecha</th>
                                            <th colspan="5">descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="horizontal dark my-2">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Metodos complementarios</h6>
                                </div>
                                <table class="table table-flush" id="data-metodos-complementarios">
                                    <thead class="thead-light">
                                        <tr class="title-table">
                                            <th class="w-10">fecha</th>
                                            <th colspan="5">examen</th>
                                            <th colspan="5">resultado</th>
                                            <th colspan="5">tipo examen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="horizontal dark my-2">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Diagnóstico presuntivo</h6>
                                </div>
                                <table class="table table-flush" id="data-diagnosticos-presuntivos">
                                    <thead class="thead-light">
                                        <tr class="title-table">
                                            <th class="w-10">fecha</th>
                                            <th colspan="5">descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="horizontal dark my-2">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Diagnóstico definitivo</h6>
                                </div>
                                <table class="table table-flush" id="data-diagnosticos-definitivos">
                                    <thead class="thead-light">
                                        <tr class="title-table">
                                            <th class="w-10">fecha</th>
                                            <th colspan="5">descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="horizontal dark my-2">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0">Evolución y pronóstico</h6>
                                </div>
                                <table class="table table-flush" id="data-evolucion">
                                    <thead class="thead-light">
                                        <tr class="title-table">
                                            <th class="w-10">fecha</th>
                                            <th colspan="5">descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-normal text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn-cancel" type="button" class="btn btn-sm bg-gradient-secondary" data-bs-dismiss="modal"><i
                        class="material-icons">close</i> Cerrar</button>
                <button id="btn-submit" type="button" class="btn bg-gradient-primary "><i
                            class="material-icons">done</i> Guardar</button>
            </div>
        </div>
    </div>
</div>
