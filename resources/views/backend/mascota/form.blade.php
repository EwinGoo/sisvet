<form id='form-main' autocomplete="off" enctype="multipart/form-data">
    <div class="row mt-3">
        <label class="form-control ms-0 p-0 px-2">Foto de la mascota:</label>
        <div class="col-12 col-sm-12 w-100 w-sm-30 m-auto mb-2">
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
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12">
            <label class="form-control ms-0 p-0">Propietario:</label>
            <div class="input-group input-group-outline" id="select-validation-id_propietario">
                <select class="form-control choices" name="id_propietario" id="id_propietario">
                    <option value="">[SELECCIONE]</option>
                    @foreach ($data['propietarios'] as $item)
                        <option value="{{ $item->id_propietario }}">{{ $item->nombre_completo }}</option>
                    @endforeach
                </select>
                <small class="select-error" error-name="id_propietario">Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="nombre_mascota" class="form-label">Nombre mascota</label>
                <input id="nombre_mascota" name="nombre_mascota" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
    </div>
    <div class="row mt-3 mt-sm-3">
        <div class="col-12 col-sm-6">
            <div class="input-group input-group-outline" id="select-validation-id_animal">
                <select class="form-control choices" name="id_animal" id="id_animal">
                    <option value="">Tipo Mascota</option>
                    @foreach ($data['animales'] as $item)
                        <option value="{{ $item->id_animal }}">{{ $item->animal }}</option>
                    @endforeach
                </select>
                <small class="select-error" error-name="id_animal">Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-sm-0 mt-3">
            <div class="input-group input-group-outline" id="select-validation-id_raza">
                <select class="form-control choices" name="id_raza" id="id_raza">
                    <option value="">Raza</option>
                    {{-- @foreach ($data['razas'] as $item)
                        <option value="{{ $item->id_raza }}">{{ $item->raza }}</option>
                    @endforeach --}}
                </select>
                <small class="select-error" error-name="id_raza">Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-3 mt-sm-3">
            <div class="input-group input-group-outline">
                <label for="color" class="form-label">Color</label>
                <input id="color" name="color" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-3 mt-sm-3">
            <label class="form-control ms-0 p-0">Género:</label>
            <div class="input-group input-group-outline">
                <div class="row w-100">
                    <div class="col-6 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" value="M" id="M">
                            <label class="form-check-label" for="M">Macho</label>
                        </div>
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" value="H" id="H">
                            <label class="form-check-label" for="H">Hembra</label>
                        </div>
                    </div>
                </div>
                <small class="text-danger" id="error-rol" style="visibility: inherit;"></small>
            </div>

            {{-- <div class="input-group input-group-outline" id="select-validation-genero">
                <select class="form-control choices" name="genero" id="genero">
                    <option value="">Género</option>
                    <option value="M">Macho</option>
                    <option value="H">Hembra</option>
                </select>
                <small class="select-error" error-name="genero">Error message</small>
            </div> --}}
        </div>
    </div>
    <div class="row mt-3 mt-sm-3">
        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
            <label class="form-control ms-0 p-0">Edad:</label>
            <div class="row">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                    <div class="input-group input-group-outline">
                        <label for="years" class="form-label">Años</label>
                        <input id="years" name="years" class="form-control" type="number" />
                        <small>Error message</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                    <div class="input-group input-group-outline">
                        <input id="meses" name="meses" class="form-control" type="number" />
                        <label for="meses" class="form-label">Meses</label>
                        <small>Error message</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
