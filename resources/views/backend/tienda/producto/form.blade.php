<form id='form-main' autocomplete="off" enctype="multipart/form-data">
    <div class="row mt-3">
        <label class="form-control ms-0 p-0 px-2">Imagen del producto:</label>
        <div class="col-12 col-sm-12 w-100 w-sm-50 m-auto mb-2">
            <div class="image-uploader h-0 m-0">
                <div class="upload-area" id="uploadArea" style="height: 100%">
                    <div class="upload-placeholder" id="placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div class="upload-text">
                            Arrastra una imagen aquí<br />o haz clic para seleccionar
                        </div>
                    </div>
                    <input type="file" id="fileInput" name="image" accept="image/*" style="display: none" />
                    <small id='error-image' class="text-danger"></small>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="nombre_producto" class="form-label">Nombre del producto</label>
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
