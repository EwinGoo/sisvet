<form id='form-main' autocomplete="off">
    <div class="row mt-3">
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="nombre" class="form-label">Titulo del Proveedor</label>
                <input id="nombre" name="nombre" class="form-control" type="text" required />
                <small id="error-nombre" class="text-danger"></small>
            </div>
        </div>

        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="contacto" class="form-label">Persona de Contacto</label>
                <input id="contacto" name="contacto" class="form-control" type="text" />
                <small id="error-contacto" class="text-danger"></small>
            </div>
        </div>

        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="celular" class="form-label">Celular</label>
                <input id="celular" name="celular" class="form-control" type="number" />
                <small id="error-celular" class="text-danger"></small>
            </div>
        </div>

        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input id="correo" name="correo" class="form-control" type="email" />
                <small id="error-correo" class="text-danger"></small>
            </div>
        </div>

        <div class="col-12 col-sm-12 mt-3">
            <label for="direccion" class="form-label">Dirección</label>
            <div class="input-group input-group-static az-input-group-outline">
                <textarea id="direccion" name="direccion" class="form-control az-area p-3" rows="2" placeholder="Dirección"></textarea>
                <small id="error-direccion" class="text-danger"></small>
            </div>
        </div>
    </div>
</form>
