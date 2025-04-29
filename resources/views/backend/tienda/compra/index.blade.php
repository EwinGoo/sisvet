@extends('backend.app')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-lg-flex">
                <div>
                    <h5 class="mb-0">Gestión de Compras</h5>
                    <p class="text-sm mb-0">Registro de compras a proveedores</p>
                </div>
                <div class="ms-auto my-auto">
                    <button id="btn-new" class="btn bg-gradient-primary btn-sm mb-0">+ Nueva Compra</button>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-0">
            <div class="table-responsive">
                <table class="table table-flush" id="datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Producto</th>
                            {{-- <th>Proveedor</th> --}}
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>fecha caducidad</th>
                            <th>Registrado por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('backend.tienda.compra.modal')
@endsection
