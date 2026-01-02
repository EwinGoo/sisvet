<form id='form-main' autocomplete="off">
    <div class="row mt-3">
        <div class="col-12 col-sm-12">
            <div class="is-filled input-group input-group-outline">
                <label for="producto" class="form-label">Seleccione producto</label>
                <input id="producto" name="producto" class="form-control" type="text" placeholder="Escriba nombre del producto"/>
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input id="cantidad" name="cantidad" class="form-control" type="number" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline is-filled">
                <label for="fecha_caducidad" class="form-label">Fecha caducidad</label>
                <input id="fecha_caducidad" name="fecha_caducidad" class="form-control" type="date" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <label for="descripcion" class="form-label">Observación</label>
            <div class="input-group input-group-static az-input-group-outline ">
                <textarea id="descripcion" name="descripcion" class="form-control az-area p-3" rows="2"
                        placeholder="Observacion para el producto"></textarea>
                <small>Error message</small>
            </div>
        </div>
    </div>
</form>
