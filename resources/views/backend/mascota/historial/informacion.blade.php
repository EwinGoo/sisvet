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
                                    href="https://api.whatsapp.com/send?phone={{ $data['info']->celular }}&text=¡Hola%20{{ urlencode($data['info']->nombre_completo) }}!%20%F0%9F%98%80%0ASomos%20*Clínica%20Veterinaria%20San%20Martín*%2C%20%F0%9F%90%B6%F0%9F%90%BE%0A%0AEstamos%20para%20atenderte."
                                    target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30"
                                        height="30" viewBox="0 0 48 48">
                                        <path fill="#fff"
                                            d="M4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5c5.1,0,9.8,2,13.4,5.6C41,14.2,43,18.9,43,24	c0,10.5-8.5,19-19,19c0,0,0,0,0,0h0c-3.2,0-6.3-0.8-9.1-2.3L4.9,43.3z">
                                        </path>
                                        <path fill="#fff"
                                            d="M4.9,43.8c-0.1,0-0.3-0.1-0.4-0.1c-0.1-0.1-0.2-0.3-0.1-0.5L7,33.5c-1.6-2.9-2.5-6.2-2.5-9.6	C4.5,13.2,13.3,4.5,24,4.5c5.2,0,10.1,2,13.8,5.7c3.7,3.7,5.7,8.6,5.7,13.8c0,10.7-8.7,19.5-19.5,19.5c-3.2,0-6.3-0.8-9.1-2.3	L5,43.8C5,43.8,4.9,43.8,4.9,43.8z">
                                        </path>
                                        <path fill="#cfd8dc"
                                            d="M24,5c5.1,0,9.8,2,13.4,5.6C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19h0c-3.2,0-6.3-0.8-9.1-2.3L4.9,43.3	l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5 M24,43L24,43L24,43 M24,43L24,43L24,43 M24,4L24,4C13,4,4,13,4,24	c0,3.4,0.8,6.7,2.5,9.6L3.9,43c-0.1,0.3,0,0.7,0.3,1c0.2,0.2,0.4,0.3,0.7,0.3c0.1,0,0.2,0,0.3,0l9.7-2.5c2.8,1.5,6,2.2,9.2,2.2	c11,0,20-9,20-20c0-5.3-2.1-10.4-5.8-14.1C34.4,6.1,29.4,4,24,4L24,4z">
                                        </path>
                                        <path fill="#40c351"
                                            d="M35.2,12.8c-3-3-6.9-4.6-11.2-4.6C15.3,8.2,8.2,15.3,8.2,24c0,3,0.8,5.9,2.4,8.4L11,33l-1.6,5.8l6-1.6l0.6,0.3	c2.4,1.4,5.2,2.2,8,2.2h0c8.7,0,15.8-7.1,15.8-15.8C39.8,19.8,38.2,15.8,35.2,12.8z">
                                        </path>
                                        <path fill="#fff" fill-rule="evenodd"
                                            d="M19.3,16c-0.4-0.8-0.7-0.8-1.1-0.8c-0.3,0-0.6,0-0.9,0s-0.8,0.1-1.3,0.6c-0.4,0.5-1.7,1.6-1.7,4	s1.7,4.6,1.9,4.9s3.3,5.3,8.1,7.2c4,1.6,4.8,1.3,5.7,1.2c0.9-0.1,2.8-1.1,3.2-2.3c0.4-1.1,0.4-2.1,0.3-2.3c-0.1-0.2-0.4-0.3-0.9-0.6	s-2.8-1.4-3.2-1.5c-0.4-0.2-0.8-0.2-1.1,0.2c-0.3,0.5-1.2,1.5-1.5,1.9c-0.3,0.3-0.6,0.4-1,0.1c-0.5-0.2-2-0.7-3.8-2.4	c-1.4-1.3-2.4-2.8-2.6-3.3c-0.3-0.5,0-0.7,0.2-1c0.2-0.2,0.5-0.6,0.7-0.8c0.2-0.3,0.3-0.5,0.5-0.8c0.2-0.3,0.1-0.6,0-0.8	C20.6,19.3,19.7,17,19.3,16z"
                                            clip-rule="evenodd"></path>
                                    </svg>
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
                                <strong class="text-dark">Sexo: </strong>{{ $data['info']->genero == 'M' ? 'MACHO':'HEMBRA' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript -->
