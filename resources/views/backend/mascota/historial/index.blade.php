@extends('backend.app')
@section('content')
    <style>
        #profile,
        #examen-general,
        #anamnesis-info,
        #sintomas,
        #diagnostico,
        #tratamiento,
        #evolucion {
            scroll-margin-top: 100px;
        }
    </style>
    <div class="col-lg-3">
        <div class="card position-sticky top-1" style="top: 9% !important">
            <ul class="nav flex-column bg-white border-radius-lg p-3">
                <li class="nav-item">
                    <a class="nav-link text-dark d-flex" data-scroll href="#profile">
                        <i class="material-icons text-lg me-2">info</i>
                        <span class="text-sm">Información general</span>
                    </a>
                </li>
                <li class="nav-item pt-2">
                    <a class="nav-link text-dark d-flex" data-scroll href="#anamnesis-info">
                        <i class="material-icons text-lg me-2">medication_liquid</i>
                        <span class="text-sm">Anamnesis</span>
                    </a>
                </li>
                <li class="nav-item pt-2">
                    <a class="nav-link text-dark d-flex" data-scroll href="#examen-general">
                        <i class="material-icons text-lg me-2">local_hospital</i>
                        <span class="text-sm">Examen general </span>
                    </a>
                </li>
                <li class="nav-item pt-2">
                    <a class="nav-link text-dark d-flex" data-scroll href="#sintomas">
                        <i class="material-icons text-lg me-2">description</i>
                        <span class="text-sm">Sintomas</span>
                    </a>
                </li>
                <li class="nav-item pt-2">
                    <a class="nav-link text-dark d-flex" data-scroll href="#diagnostico">
                        <i class="material-icons text-lg me-2">content_paste_search</i>
                        <span class="text-sm">Diagnostico</span>
                    </a>
                </li>
                <li class="nav-item pt-2">
                    <a class="nav-link text-dark d-flex" data-scroll href="#tratamiento">
                        <i class="material-icons text-lg me-2">app_registration</i>
                        <span class="text-sm">Tratamiento</span>
                    </a>
                </li>
                <li class="nav-item pt-2">
                    <a class="nav-link text-dark d-flex" data-scroll href="#evolucion">
                        <i class="material-icons text-lg me-2">track_changes</i>
                        <span class="text-sm">Evolucion y pronostico</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-lg-9 mt-lg-0 mt-4 az-information">
        <div class="card" id="profile" data-id="{{$data['info']->id_historial}}">
            <div class="card-header p-3 pt-3 pb-1">
                <div
                    class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-xl mt-n4 me-3 float-start">
                    <i class="material-icons opacity-10">event</i>
                </div>
                <h6 class="mb-0 text-uppercase">Información del propietario y la mascota</h6>
            </div>
            <div class="card-body pt-2">
                <div class="row">
                    <div class="row mt-3">
                        <div class="col-12 col-md-6 col-xl-6 position-relative">
                            <div class="card card-plain h-100">
                                <div class="card-header py-0 ">

                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-sm-auto col-4">
                                            <div class="avatar avatar-xl position-relative">
                                                <img src="https://png.pngtree.com/png-clipart/20230927/original/pngtree-man-avatar-image-for-profile-png-image_13001877.png"
                                                    alt="bruce" class="w-100 rounded-circle shadow-sm" />
                                            </div>
                                        </div>
                                        <div class="col-sm-auto col-8 my-auto">
                                            <div class="h-100">
                                                <h5 class="mb-1 font-weight-bolder">{{ $data['info']->nombre_completo }}
                                                </h5>
                                                <p class="mb-0 font-weight-normal text-sm">
                                                    Propietario
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                                        </div>
                                    </div>


                                </div>
                                <hr class="horizontal dark" />
                                <div class="card-body p-3">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                            <strong class="text-dark">Celular:</strong> {{ $data['info']->celular }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0  pt-0 text-sm">
                                            <strong class="text-dark">Dirección:</strong>{{ $data['info']->direccion }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0  pt-0 pb-0">
                                            <strong class="text-dark text-sm">Social:</strong>
                                            <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0"
                                                href="https://api.whatsapp.com/send?phone={{ $data['info']->celular }}"
                                                target="_blank">
                                                <i class="fab fa-whatsapp fa-lg"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <hr class="vertical dark" />
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-md-0 mt-4 position-relative">
                            <div class="card card-plain h-100">
                                <div class="card-header py-0 p-3">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-sm-auto col-4">
                                            <div class="avatar avatar-xl position-relative">
                                                <img src="{{ asset('assets/images/dog-cat.png') }}" alt="bruce"
                                                    class="w-100 rounded-circle shadow-sm" />
                                            </div>
                                        </div>
                                        <div class="col-sm-auto col-8 my-auto">
                                            <div class="h-100">
                                                <h5 class="mb-1 font-weight-bolder">{{ $data['info']->nombre_mascota }}</h5>
                                                <p class="mb-0 font-weight-normal text-sm">
                                                    Mascota
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                                            <span class="badge bg-gradient-info">{{ $data['info']->animal }}</span>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark" />
                                <div class="card-body p-3">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                            <strong class="text-dark">Edad:</strong>
                                            {{ $data['info']->years ? $data['info']->years . ' años y' : '' }}
                                            {{ $data['info']->meses ? $data['info']->meses . ' meses' : '' }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                            <strong class="text-dark">Color:</strong> {{ $data['info']->color }}
                                        </li>
                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                            <strong class="text-dark">Sexo:</strong>{{ $data['info']->genero }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2" id="anamnesis-info">
            <div class="card-header pb-2">
                <div class="row">
                    <div class="col-md-8">
                        <h6>ANAMNESIS</h6>
                    </div>
                    <div class="col-md-4 text-end">
                        <a id="btn-new" href="javascript:;" class="btn btn-primary btn-sm new"
                            data-action="anamnesis">
                            <i class="fas fa-user-edit text-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Edit Profile"></i> Editar
                        </a>
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

        <div class="card mt-2">
            <div class="card-header pb-3" id="examen-general">
                <div class="d-lg-flex">
                    <div>
                        <h6>EXAMEN GENERAL</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button id="btn-new" type="button" class="btn bg-gradient-secondary btn-sm mb-0 new"
                                data-action="examen">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-examen">
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
                                    R.S. SEG
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <span class="h6 mb-1 text-gradient text-info">
                        Inspección:
                    </span>
                    <span>

                    </span>
                </div>
                <div class="col-12">
                    <span class="h6 mb-1 text-gradient text-info">
                        Palpitación:
                    </span>
                    <span>

                    </span>
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
                                class="btn bg-gradient-secondary btn-sm mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-sintomas">
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
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="horizontal dark m-0" />
            <div class="card-header pb-3" id="diagnostico">
                <div class="d-lg-flex">
                    <div>
                        <h6>DIAGNOSTICO PRESUNTIVO / DEFINITIVO</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="diagnostico" id="btn-new" type="button"
                                class="btn bg-gradient-secondary btn-sm mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-diagnostico">
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
                                class="btn btn-sm bg-gradient-secondary  mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-tratamiento">
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
                        <h6>EVOLUCIÓN Y PRONÓSTICO</h6>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button data-action="evolucion" id="btn-new" type="button"
                                class="btn bg-gradient-secondary btn-sm mb-0 new">+
                                Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="table-evolucion">
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
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('backend.mascota.historial.modal')
@endsection
