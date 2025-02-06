<div class="card-header p-3 pt-3 pb-1">
    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-xl mt-n4 me-3 float-start">
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
                                        alt="bruce" class="w-100 rounded-circle shadow-sm img-preview" />
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
                            <li class="list-group-item border-0 ps-0 pt-0 text-md">
                                <strong class="text-dark">Celular: </strong> {{ $data['info']->celular }}
                            </li>
                            <li class="list-group-item border-0 ps-0  pt-0 text-md">
                                <strong class="text-dark">Dirección: </strong> {{ $data['info']->direccion }}
                            </li>
                            <li class="list-group-item border-0 ps-0  pt-0 pb-0">
                                <strong class="text-dark text-md">Social: </strong>
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
                        <div class="row justify-content-center align-items-center text-center">
                            <div class="col-sm-auto col-4">
                                <div class="avatar avatar-xl position-relative">
                                    <img src="{{ $data['info']->ruta_archivo ? Storage::url($data['info']->ruta_archivo) : asset('assets/images/silueta-dog-cat.jpg') }}"
                                        alt="bruce" class="w-100 h-100 rounded-circle shadow-sm img-preview" />
                                </div>
                            </div>
                            <div class="col-sm-auto col-8 my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1 font-weight-bolder">{{ $data['info']->nombre_mascota }}</h5>
                                    <p class="mb-0 font-weight-normal text-md">
                                        Mascota
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-auto col-12 ms-sm-auto mt-sm-0 mt-3">
                                <span class="badge bg-gradient-info badge-md">{{ $data['info']->animal }}</span>
                                <br>
                                <p class="mb-0 font-weight-normal text-sm mt-2">
                                    Tipo Mascota
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark" />
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0 text-md">
                                <strong class="text-dark">Edad:</strong>
                                {{ $data['info']->years ? $data['info']->years . ' años y' : '' }}
                                {{ $data['info']->meses ? $data['info']->meses . ' meses' : '' }}
                            </li>
                            <li class="list-group-item border-0 ps-0 pt-0 text-md">
                                <strong class="text-dark">Color: </strong> {{ $data['info']->color }}
                            </li>
                            <li class="list-group-item border-0 ps-0 pt-0 text-md">
                                <strong class="text-dark">Sexo: </strong>{{ $data['info']->genero }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript -->
