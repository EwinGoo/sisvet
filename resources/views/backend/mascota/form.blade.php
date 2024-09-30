<form id='form-main'>
    <div class="row mt-3">
        <div class="col-12 col-sm-12">
            <label class="form-control ms-0 p-0">Propietario</label>
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
                    @foreach ($data['razas'] as $item)
                        <option value="{{ $item->id_raza }}">{{ $item->raza }}</option>
                    @endforeach
                </select>
                <small class="select-error" error-name="id_raza">Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-3 mt-sm-3">
            <div class="input-group input-group-outline">
                <label for="edad" class="form-label">Edad</label>
                <input id="edad" name="edad" class="form-control" type="number" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-3 mt-sm-3">
            <div class="input-group input-group-outline" id="select-validation-genero">
                <select class="form-control choices" name="genero" id="genero">
                    <option value="">Género</option>
                    <option value="M">Macho</option>
                    <option value="H">Hembra</option>
                </select>
                <small class="select-error" error-name="genero">Error message</small>
            </div>
        </div>
    </div>
    <div class="row mt-3 mt-sm-3">
        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
            <div class="input-group input-group-outline">
                <label for="color" class="form-label">Color</label>
                <input id="color" name="color" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
            <div class="input-group input-group-outline">
                <label for="vacunas" class="form-label">Vacunas</label>
                <input id="vacunas" name="vacunas" class="form-control" type="number" />
                <small>Error message</small>
            </div>
        </div>
    </div>
</form>
