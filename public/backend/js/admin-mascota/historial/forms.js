export function anamnesisForm() {
    return `
        <form action="modal-main">
        <div class="row">
            <div class="col-12 col-md-6">
                <label for="enfermedades_anteriores" class="form-control ms-0 mb-0">Enfermedades
                    anteriores</label>
                <div class="input-group input-group-static az-input-group-outline">
                    <textarea id="enfermedades_anteriores" name="enfermedades_anteriores" class="form-control az-area p-3" rows="2"
                        placeholder="Descripción de enfermedades anteriores" spellcheck="false"></textarea>
                    <small>Error message</small>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <label for="tratamientos_recientes" class="form-control ms-0 mb-0">Tratamientos
                    recientes</label>
                <div class="input-group input-group-static az-input-group-outline ">
                    <textarea id="tratamientos_recientes" name="tratamientos_recientes" class="form-control az-area p-3" rows="2"
                        placeholder="Descripción de tratamientos recientes" spellcheck="false"></textarea>
                    <small>Error message</small>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <label for="ultima_desparasitacion" class="form-control ms-0 mb-0">Ultima
                    desparacitación</label>
                <div class="input-group input-group-static az-input-group-outline ">
                    <textarea id="ultima_desparasitacion" name="ultima_desparasitacion" class="form-control az-area p-3" rows="2"
                        placeholder="Descripción de ultima desparacitación" spellcheck="false"></textarea>
                    <small>Error message</small>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <label for="vacunas" class="form-control ms-0 mb-0">Vacunas</label>
                <div class="input-group input-group-static az-input-group-outline ">
                    <textarea id="vacunas" name="vacunas" class="form-control az-area p-3" rows="2" placeholder=""
                        spellcheck="false"></textarea>
                    <small>Error message</small>
                </div>
            </div>
        </div>
    </form>
    `;
}
export function examenForm() {
    return `
    <form id='form-main'>
        <div class="row mt-3">
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" placeholder="" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 mt-sm-0 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="temperatura">Temperatura</label>
                    <input type="number" name="temperatura" id="temperatura" step="00.1" class="form-control"
                        placeholder="00.0" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 ">
                <div class="input-group input-group-static">
                    <label for="frecuencia_cardiaca">Frecuencia cardiaca</label>
                    <input type="number" name="frecuencia_cardiaca" id="frecuencia_cardiaca" class="form-control"
                        placeholder="" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 ">
                <div class="input-group input-group-static">
                    <label for="frecuencia_respiratoria">Frecuencia respiratoria</label>
                    <input type="number" name="frecuencia_respiratoria" id="frecuencia_respiratoria" class="form-control"
                        placeholder="" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <div class="input-group input-group-static">
                    <label for="mucosa">Mucosa</label>
                    <input type="text" name="mucosa" id="mucosa" class="form-control" placeholder="" />
                </div>
            </div>
            <div class="col-6 col-sm-6 mt-3">
                <div class="input-group input-group-static">
                    <label for="rc">R.S. SEG</label>
                    <input type="text" name="rc" id="rc" class="form-control" placeholder="" />
                </div>
            </div>
            <div class="col-12 col-sm-12 mt-3">
                <div class="input-group input-group-static">
                    <label for="inspeccion">Inspección</label>
                    <input type="text" name="inspeccion" id="inspeccion" class="form-control" placeholder="" />
                </div>
            </div>
            <div class="col-12 col-sm-12 mt-3">
                <div class="input-group input-group-static">
                    <label for="palpitacion">Palpitación</label>
                    <input type="text" name="palpitacion" id="palpitacion" class="form-control" placeholder="" />
                </div>
            </div>
        </div>
    </form>
    `;
}
export function genericForm() {
    return `
   <form id='form-main'>
        <div class="row mt-3">
            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" placeholder="" />
                </div>
            </div>
            <div class="col-12 col-sm-12 mt-3 ">
                <label for="descripcion" class="form-control ms-0 mb-0">Descripción</label>
                <div class="input-group input-group-static az-input-group-outline">
                    <textarea id="descripcion" name="descripcion" class="form-control az-area p-3" rows="2" placeholder=""
                        spellcheck="false"></textarea>
                    <small>Error message</small>
                </div>
            </div>
        </div>
    </form>
    `;
}
export function evolucionForm() {
    return `
    <form id='form-main'>
        <div class="row mt-3">
            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="fecha">Fecha</label>
                    <input type="datetime-local" name="fecha" id="fecha" class="form-control" placeholder="" />
                </div>
            </div>
            <div class="col-12 col-sm-12 mt-3 ">
                <label for="descripcion" class="form-control ms-0 mb-0">Descripción</label>
                <div class="input-group input-group-static az-input-group-outline">
                    <textarea id="descripcion" name="descripcion" class="form-control az-area p-3" rows="2" placeholder=""
                        spellcheck="false"></textarea>
                    <small>Error message</small>
                </div>
            </div>
        </div>
    </form>
    `;
}
