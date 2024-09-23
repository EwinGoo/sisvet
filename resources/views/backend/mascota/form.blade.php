<form id='form-main'>
    <div class="row mt-3">
        <div class="col-12 col-sm-6">
            <div class="input-group input-group-outline">
                <label for="nombre_mascota" class="form-label">Nombre mascota</label>
                <input id="nombre_mascota" name="nombre_mascota" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-3 mb-4">
            <div class="input-group input-group-outline" id="select-validation-id_propietario">
                <select class="form-control choices" name="id_propietario" id="id_propietario">
                    <option value="">Propietario</option>
                    @foreach ($data['propietarios'] as $item)
                        <option value="{{ $item->id_propietario }}">{{ $item->nombre_completo }}</option>
                    @endforeach
                </select>
                <small class="select-error" error-name="id_propietario">Error message</small>
            </div>
        </div>
    </div>
    <!-- <div class="row mt-4 mt-sm-4">
        <div class="col-12 col-sm-6  mt-5 mt-sm-0">
            <div class="input-group input-group-outline">
                <label for="paterno" class="form-label">Paterno</label>
                <input id="paterno" name="paterno" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-5 mt-sm-0">
            <div class="input-group input-group-outline">
                <label for="materno" class="form-label">Materno<span class="text-muted">
                    </span> </label>
                <input id="materno" name="materno" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
    </div>
    <div class="row mt-4 mt-sm-4">
        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
            <div class="input-group input-group-outline">
                <label for="celular" class="form-label">Celular</label>
                <input id="celular" name="celular" class="form-control" type="text" maxlength="8"
                    minlength="8" />
                <small>Error message</small>
            </div>
        </div>
    </div> -->
</form>
