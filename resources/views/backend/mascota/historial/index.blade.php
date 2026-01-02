@extends('backend.app')
@section('content')
    <div class="col-lg-2">
        @include('backend.mascota.historial.sidenav')
    </div>
    <div class="col-lg-10 mt-lg-0 mt-4 az-information">
        <div class="card" id="profile" data-id="{{ $data['info']->id_historial }}">
            @include('backend.mascota.historial.informacion')
        </div>
        <div class="card mt-2" id="anamnesis-info">
            <div class="card-header pb-2">
                <div class="row">
                    <div class="col-md-8">
                        <h6>ANAMNESIS</h6>
                    </div>
                    <div class="col-md-4 text-end">
                        <a id="btn-new" href="javascript:;" class="btn btn-primary btn-small new" data-action="anamnesis">
                            <i class="fas fa-user-edit text-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Edit Profile"></i><i class="material-icons text-sm">edit</i> Editar</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 pb-1">
                <div class="card mt-lg-0 mt-4 card-plain">
                    <div class="row align-items-center mb-3">
                        <div class="col-12">
                            <span class="h6 mb-1 text-gradient text-info">
                                Enfermedades anteriores:
                            </span>
                            <span id="enf_ant"></span>
                        </div>
                        <div class="col-12 mt-2">
                            <span class="h6 mb-1 text-gradient text-info">
                                Tratamientos recientes:
                            </span>
                            <span id="tra_rec"></span>
                        </div>
                        <div class="col-12 mt-2">
                            <span class="h6 mb-1 text-gradient text-info">
                                Vacunas:
                            </span>
                            <span id="vac"></span>
                        </div>
                        <div class="col-12 mt-2">
                            <span class="h6 mb-1 text-gradient text-info">
                                Ultima desparacitación:
                            </span>
                            <span id="ult_des"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2" id="vacunas-info">
            <div class="card-header pb-2">
                <div class="d-lg-flex">
                    <div>
                        <h6>VACUNAS</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="vacunas" id="btn-new" type="button"
                                class="btn btn-outline-secondary btn-small mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-vacunas" data-type="vacunas">
                        <thead>
                            <tr>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    N°
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Fecha
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Vacuna
                                </th>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7 text-end">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header pb-3" id="examen-general">
                <div class="d-lg-flex">
                    <div>
                        <h6>EXAMEN GENERAL</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button id="btn-new" type="button" class="btn btn-outline-secondary btn-small mb-0 new"
                                data-action="examen">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-examen" data-type="examen">
                        <thead>
                            <tr>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    N°
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Fecha
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Temperatura
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Frecuencia cardiaca
                                </th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Frecuencia respiratoria
                                </th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Mucosa
                                </th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                    R.C. SEG
                                </th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-3">
                    <span class="h6 mb-1 text-gradient text-info">
                        Inspección:
                    </span>
                    <span id="inspeccion-info"></span>
                </div>
                <div class="col-12">
                    <span class="h6 mb-1 text-gradient text-info">
                        Palpación:
                    </span>
                    <span id='palpacion-info'></span>
                </div>
            </div>
            <hr class="horizontal dark m-0" />
            <div class="card-header pb-3" id="sintomas">
                <div class="d-lg-flex">
                    <div>
                        <h6>SINTOMAS</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="sintomas" id="btn-new" type="button"
                                class="btn btn-outline-secondary btn-small mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-sintomas" data-type="sintomas">
                        <thead>
                            <tr>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    N°
                                </th>
                                <th class="w-10 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Fecha
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Descripción
                                </th>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7 text-end">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="horizontal dark m-0" />
            <div class="card-header pb-3" id="metodos-complementarios">
                <div class="d-lg-flex">
                    <div>
                        <h6>METODOS COMPLEMENTARIOS</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="metodos_complementarios" id="btn-new" type="button"
                                class="btn btn-outline-secondary btn-small mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-metodos-complementarios"
                        data-type="metodos_complementarios">
                        <thead>
                            <tr>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    N°
                                </th>
                                <th class="w-10 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Fecha
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Resultados
                                </th>
                                <th class="w-6 text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Tipo Examen
                                </th>
                                <th class="w-6 text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Imagen
                                </th>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7 text-end">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="horizontal dark m-0" />
            <div class="card-header pb-3" id="diagnostico-presuntivo">
                <div class="d-lg-flex">
                    <div>
                        <h6>DIAGNÓSTICO PRESUNTIVO</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="diagnosticos_presuntivos" id="btn-new" type="button"
                                class="btn btn-outline-secondary btn-small mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-diagnostico-presuntivo"
                        data-type="diagnosticos_presuntivos">
                        <thead>
                            <tr>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    N°
                                </th>
                                <th class="w-10 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Fecha
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Descripción
                                </th>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7 text-end">
                                    Acciones
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="horizontal dark m-0" />
            <div class="card-header pb-3" id="diagnostico-definitivo">
                <div class="d-lg-flex">
                    <div>
                        <h6>DIAGNÓSTICO DEFINITIVO</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="diagnosticos_definitivos" id="btn-new" type="button"
                                class="btn btn-outline-secondary btn-small mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-diagnostico-definitivo"
                        data-type="diagnosticos_definitivos">
                        <thead>
                            <tr>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    N°
                                </th>
                                <th class="w-10 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Fecha
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Descripción
                                </th>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7 text-end">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="horizontal dark m-0" />
            <div class="card-header pb-3" id="tratamiento">
                <div class="d-lg-flex">
                    <div>
                        <h6>TRATAMIENTO</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="tratamiento" id="btn-new" type="button"
                                class="btn btn-small btn-outline-secondary  mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-tratamiento" data-type="tratamiento">
                        <thead>
                            <tr>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    N°
                                </th>
                                <th class="w-10 text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Fecha
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                    Descripción
                                </th>
                                <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7 text-end">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="horizontal dark m-0" />
            <div class="card-header pb-3" id="evolucion">
                <div class="d-lg-flex">
                    <div>
                        <h6 data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                            aria-controls="collapseExample">EVOLUCIÓN Y PRONÓSTICO</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="evolucion" id="btn-new" type="button"
                                class="btn btn-outline-secondary btn-small mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse show" id="collapseExample">
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0" id="table-evolucion" data-type="evolucion">
                            <thead>
                                <tr>
                                    <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7">
                                        N°
                                    </th>
                                    <th class="w-10 text-uppercase text-xxs font-weight-bolder opacity-7">
                                        Fecha y hora
                                    </th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                        Descripción
                                    </th>
                                    <th class="w-5 text-uppercase text-xxs font-weight-bolder opacity-7 text-end">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.mascota.historial.modal')
@endsection
