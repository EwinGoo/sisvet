@extends('backend.app')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">Nueva venta</h5>
                <div class="row">
                    <div class="col-xl-5 col-lg-5 position-relative px-4">
                        <h6 class="mb-4 d-flex align-items-center"><i class="material-icons mx-3">person</i> Datos cliente
                        </h6>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="input-group input-group-dynamic mb-4">
                                    <span class="input-group-text" id="basic-addon1">Codigo</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="input-group input-group-dynamic mb-4">
                                    <span class="input-group-text" id="basic-addon1">Cliente</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <h6 class="mb-4 d-flex align-items-center"><i class="material-icons mx-3 ">inventory_2</i> Datos
                            producto</h6>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="input-group input-group-dynamic mb-4">
                                    <span class="input-group-text" id="basic-addon1">Codigo</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="input-group input-group-dynamic mb-4">
                                    <span class="input-group-text" id="basic-addon1">Producto</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group input-group-dynamic mb-4">
                                    <span class="input-group-text" id="basic-addon1">Precio</span>
                                    <input type="number" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group input-group-dynamic mb-4">
                                    <span class="input-group-text" id="basic-addon1">Cantidad</span>
                                    <input type="number" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <button type="button" class="btn bg-gradient-primary">+ Agregar</button>
                            </div>
                        </div>
                        <hr class="vertical dark">
                    </div>
                    <div class="col-lg-7 mx-auto">
                        <h6 class="ms-3">Detalles de venta</h6>
                        <div class="table table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Codigo
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Producto
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Precio
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            cantidad
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Disponibilidad
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            acción
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-sm">230019</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/black-chair.jpg"
                                                        class="avatar avatar-md me-3" alt="table image" />
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        Christopher Knight Home
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm text-secondary mb-0">Bs. 89.53</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm text-secondary mb-0">2</p>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <div class="progress mx-auto">
                                                <div class="progress-bar bg-gradient-success" role="progressbar"
                                                    style="width: 80%" aria-valuenow="80" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a data-id="${id}" href="javascript:;" class="ms-3 delete"
                                                data-bs-toggle="tooltip" data-bs-original-title="Quitar">
                                                <i class="material-icons text-danger position-relative text-lg">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-sm">412301</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/chair-steel.jpg"
                                                        class="avatar avatar-md me-3" alt="table image" />
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        Signature Design by Ashley
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm text-secondary mb-0">Bs. 129.00</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm text-secondary mb-0">3</p>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <div class="progress mx-auto">
                                                <div class="progress-bar bg-gradient-warning" role="progressbar"
                                                    style="width: 60%" aria-valuenow="60" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a data-id="${id}" href="javascript:;" class="ms-3 delete"
                                                data-bs-toggle="tooltip" data-bs-original-title="Quitar">
                                                <i class="material-icons text-danger position-relative text-lg">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-sm">001992</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/chair-wood.jpg"
                                                        class="avatar avatar-md me-3" alt="table image" />
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">Modern Square</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm text-secondary mb-0">Bs. 59.99</p>
                                        </td>
                                        <td  class="text-center">
                                            <p class="text-sm text-secondary mb-0">10</p>
                                        </td>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <div class="progress mx-auto">
                                                <div class="progress-bar bg-gradient-warning" role="progressbar"
                                                    style="width: 40%" aria-valuenow="40" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a data-id="${id}" href="javascript:;" class="ms-3 delete"
                                                data-bs-toggle="tooltip" data-bs-original-title="Quitar">
                                                <i class="material-icons text-danger position-relative text-lg">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class=""> 
                                        <td colspan="4">
                                            <button type="button" class="btn btn-sm bg-gradient-success m-0"><i class="material-icons position-relative text-lg">new_label</i> Generar venta</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger m-0"><i class="material-icons position-relative text-lg">cancel</i> cancelar</button>
                                        </td>
                                        <td>
                                            <p class="text-sm text-bold text-center mb-0">Total a pagar:</p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-bold text-center mb-0">Bs. 300</p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.tienda.ventas.modal')
@endsection
