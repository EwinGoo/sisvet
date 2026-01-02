<form id="form-main" autocomplete="off">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="input-group input-group-static" id="select-validation-id_producto">
                <label>Producto *</label>
                <select name="id_producto" class="form-control choices" id="id_producto">
                    <option value="">[SELECCIONE]</option>
                    @foreach ($data['productos'] as $producto)
                        <option value="{{ $producto->id_producto }}">{{ $producto->nombre_producto }}</option>
                    @endforeach
                </select>
                <small class="select-error" error-name="id_producto">Error message</small>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="input-group input-group-static" id="select-validation-id_proveedor">
                <label>Proveedor *</label>
                <select name="id_proveedor" class="form-control choices" id="id_proveedor">
                    <option value="">[SELECCIONE]</option>
                    @foreach ($data['proveedores'] as $proveedor)
                        <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
                <small class="select-error" error-name="id_proveedor">Error message</small>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="input-group input-group-outline is-filled">
                <label for="fecha_compra" class="form-label">Fecha de compra *</label>
                <input type="date" name="fecha_compra" class="form-control">
                <small>Error message</small>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="input-group input-group-outline is-filled">
                <label for="fecha_caducidad" class="form-label">Fecha de Caducidad *</label>
                <input type="date" name="fecha_caducidad" class="form-control">
                <small>Error message</small>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="input-group input-group-outline">
                <label for="precio_compra" class="form-label">Precio Compra *</label>
                <input type="number" name="precio_compra" class="form-control" step="0.01">
                <small>Error message</small>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="input-group input-group-outline">
                <label for="precio_venta" class="form-label">Precio Venta *</label>
                <input type="number" name="precio_venta" class="form-control" step="0.01">
                <small>Error message</small>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="input-group input-group-outline">
                <label for="cantidad_compra" class="form-label">Cantidad *</label>
                <input type="number" name="cantidad_compra" class="form-control">
                <small>Error message</small>
            </div>
        </div>
    </div>
</form>
