<form id='form-main' autocomplete="off">
    <div class="row mt-3">
        <div class="col-12 col-sm-12">
            <div class="input-group input-group-outline">
                <label for="nombre_producto" class="form-label">Nombre del nombre</label>
                <input id="nombre_producto" name="nombre_producto" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3 mt-sm-3">
            <label class="form-control ms-0">Categoría</label>
            <div class="input-group input-group-outline" id="select-validation-id_categoria">
                <select class="form-control choices" name="id_categoria" id="id_categoria">
                    <option value="">[SELECCIONE]</option>
                    @foreach ($data['categorias'] as $item)
                        <option value="{{$item->id_categoria}}">{{$item->nombre_categoria}}</option>
                    @endforeach

                </select>
                <small class="select-error" error-name="id_categoria">Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <div class="input-group input-group-static az-input-group-outline ">
                <textarea id="descripcion" name="descripcion" class="form-control az-area p-3" rows="2" placeholder="Descripción"></textarea>
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
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento</label>
                <input id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" type="date" />
                <small>Error message</small>
            </div>
        </div>
    </div>
</form>
