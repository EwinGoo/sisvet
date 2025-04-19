@extends('backend.app')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-lg-flex">
                    <div>
                        <h5 class="mb-0">Nueva venta</h5>
                        <p class="text-sm mb-0">
                            Registrar y completar una transacción de venta de productos
                        </p>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0 mt-4">
                        <div class="ms-auto my-auto">
                            <button id="btn-add-client" type="button" class="btn bg-gradient-primary btn-sm mb-0"
                                target="_blank" data-bs-toggle="modal" data-bs-target="#modal-main">+&nbsp;
                                Nuevo cliente</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="ventaForm" method="POST">
                    @csrf
                    <div id="productos-hidden"></div>
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 position-relative px-4">
                            <h6 class="mb-4 d-flex align-items-center"><i class="material-icons mx-3">person</i> Datos
                                cliente
                            </h6>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <span class="input-group-text" id="basic-addon1">C.I.</span>
                                        <input name="ci_cliente" id="ci" type="text" class="form-control"
                                            placeholder="Buscar por cedula.">
                                        <input type="hidden" name="id_cliente">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <span class="input-group-text" id="nombre">Cliente</span>
                                        <input name="nombre_cliente" id="nombre" type="text" class="form-control"
                                            placeholder="Nombre Completo">
                                    </div>
                                </div>
                            </div>
                            <h6 class="mb-4 d-flex align-items-center"><i class="material-icons mx-3 ">inventory_2</i> Datos
                                producto</h6>
                            {{-- <span class="mb-2 text-sm text-warning">Puede buscar el producto por nombre o codigo</span> --}}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <span class="input-group-text" id="id_producto">Buscador</span>
                                        <input id="buscador" type="text" class="form-control"
                                            placeholder="Buscar por nombre del producto">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <span class="input-group-text" id="id_producto">Codigo</span>
                                        <input disabled name="id_producto" id="id_producto" type="text"
                                            class="form-control" placeholder="Codigo">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <span class="input-group-text" id="nombre_producto">Producto</span>
                                        <input disabled name="nombre_producto" id="nombre_producto" type="text"
                                            class="form-control" placeholder="Producto">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <span class="input-group-text" id="precio">Precio</span>
                                        <input disabled name="precio" id="precio" type="number" class="form-control"
                                            placeholder="Precio">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <span class="input-group-text" id="cantidad">Cantidad</span>
                                        <input name="cantidad" id="cantidad" type="number" class="form-control"
                                            placeholder="Cantidad">
                                        <small id="stock-info" class="text-sm text-secondary ms-2">Stock disponible: 0</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button id="btn-add-product" type="button" class="btn bg-gradient-primary">+
                                        Agregar</button>
                                </div>
                            </div>
                            <hr class="vertical dark">
                        </div>
                        <div class="col-lg-7 mx-auto">
                            <h6 class="ms-3">Detalles de venta</h6>
                            <div class="table table-responsive">
                                <table id="sales-details" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Codigo
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
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
                                    </tbody>
                                    <tfoot>
                                        <tr class="">
                                            <td colspan="4">
                                                <button id="btn-generate-sale" type="button"
                                                    class="btn btn-sm bg-gradient-success m-0"><i
                                                        class="material-icons position-relative text-lg">new_label</i>
                                                    Generar
                                                    venta</button>
                                                <button id="btn-cancel-sale" type="button"
                                                    class="btn btn-sm btn-outline-danger m-0"><i
                                                        class="material-icons position-relative text-lg">cancel</i>
                                                    cancelar</button>
                                            </td>
                                            <td>
                                                <p class="text-sm text-bold text-center mb-0">Total a pagar:</p>
                                            </td>
                                            <td>
                                                <p id="total-amount" class="text-sm text-bold text-center mb-0">Bs. 0</p>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="total_venta" id="total_venta">
                </form>
            </div>
        </div>
    </div>
    @include('backend.tienda.cliente.modal')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection
