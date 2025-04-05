<form id='form-main'>
    <div class="row mt-3 mb-2">
        <div class="col-12 col-sm-12 mt-3 mt-sm-0">
            <div class="input-group input-group-outline">
                <label for="raza" class="form-label">Nombre de la Raza</label>
                <input id="raza" name="raza" class="form-control" type="text" />
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3 mt-sm-3">
            <label class="form-control ms-0 p-0">Tipo Animal:</label>
            <div class="input-group input-group-outline" id="select-validation-id_animal">
                <select id="id_animal" name="id_animal" class="form-control choices">
                    <option value="">[SELECCIONE]</option>
                    @foreach($data['animales'] as $animal)
                        <option value="{{ $animal->id_animal }}">{{ $animal->animal }}</option>
                    @endforeach
                </select>
                <small class="select-error" error-name="id_animal">Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3 mt-sm-3">
            <label class="form-control ms-0 p-0">Descripción:</label>
            <div class="input-group input-group-outline">
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3"></textarea>
                <small>Error message</small>
            </div>
        </div>
    </div>
</form>
