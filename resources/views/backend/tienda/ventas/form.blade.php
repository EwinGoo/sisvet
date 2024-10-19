<form id='form-main' autocomplete="off">
    <div class="row mt-3">
        <div class="col-12 col-sm-12">
            <div class="input-group input-group-outline">
                <label for="producto" class="form-label">Nombre del producto</label>
                <input id="producto" name="producto" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <div class="input-group input-group-static az-input-group-outline ">
                <textarea id="descripcion" name="descripcion" class="form-control az-area p-3" rows="2"
                        placeholder="Descripción"></textarea>
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="precio" class="form-label">Precio</label>
                <input id="precio" name="precio" class="form-control" type="number" />
                <small>Error message</small>
            </div>
        </div>
    </div>
</form>
