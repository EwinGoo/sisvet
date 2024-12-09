export function anamnesisForm() {
    return /*html*/ `
        <form action="form-main">
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
                <label for="vacunas" class="form-control ms-0 mb-0">Vacunas</label>
                <div class="input-group input-group-static az-input-group-outline ">
                    <textarea id="vacunas" name="vacunas" class="form-control az-area p-3" rows="2" placeholder=""
                        spellcheck="false"></textarea>
                    <small>Error message</small>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <label for="ultima_desparasitacion" class="form-control ms-0 mb-0">Ultima
                    desparacitación</label>
                <div class="input-group input-group-static">
                    <input type="date" name="ultima_desparasitacion" id="ultima_desparasitacion" class="form-control" placeholder="" />
                    <small>Error message</small>
                </div>
            </div>
        </div>
    </form>
    `;
}
export function examenForm() {
    return /*html*/ `
    <form id='form-main'>
        <div class="row mt-3">
            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" placeholder="" value="${
                        getFecha().date
                    }" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3 mt-sm-0 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="temperatura">Temperatura</label>
                    <input type="number" name="temperatura" id="temperatura" step="00.1" class="form-control"
                        placeholder="00.0" value="38.0"/>
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
            <div class="form-check p-0 mt-4">
                <label class="form-check-label text-warning" for="isUpdateTwoFields">
                    ¿Actualizar estos campos?
                </label>
                <input type="checkbox" class="form-check-input" name="isUpdateTwoFields" id="isUpdateTwoFields" />
            </div>
            <div class="col-12 col-sm-12 mt-3">
                <div class="input-group input-group-static">
                    <label for="inspeccion">Inspección</label>
                    <input type="text" name="inspeccion" id="inspeccion" class="form-control" placeholder="" />
                </div>
            </div>
            <div class="col-12 col-sm-12 mt-3">
                <div class="input-group input-group-static">
                    <label for="palpacion">Palpación</label>
                    <input type="text" name="palpacion" id="palpacion" class="form-control" placeholder="" />
                </div>
            </div>
        </div>
    </form>
    `;
}
export function genericForm(isConfirmed = 0) {
    return /*html*/ `
   <form id='form-main'>
        <div class="row mt-3">
            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" placeholder="" value="${
                        getFecha().date
                    }" />
                </div>
            </div>
            ${
                isConfirmed
                    ? /*HTML */ `
                    <div class="col-12 col-sm-12 mt-3 ">
                        <label for="examen" class="form-control ms-0 mb-0">Examen</label>
                        <div class="input-group input-group-static az-input-group-outline">
                            <textarea id="examen" name="examen" class="form-control az-area p-3" rows="2" placeholder=""
                                spellcheck="false"></textarea>
                            <small>Error message</small>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 mt-3 ">
                        <label for="resultados" class="form-control ms-0 mb-0">Resultados</label>
                        <div class="input-group input-group-static az-input-group-outline">
                            <textarea id="resultados" name="resultados" class="form-control az-area p-3" rows="2" placeholder=""
                                spellcheck="false"></textarea>
                            <small>Error message</small>
                        </div>
                    </div>
                    `
                    : /*HTML*/ `
                    <div class="col-12 col-sm-12 mt-3 ">
                        <label for="descripcion" class="form-control ms-0 mb-0">Descripción</label>
                        <div class="input-group input-group-static az-input-group-outline">
                            <textarea id="descripcion" name="descripcion" class="form-control az-area p-3" rows="2" placeholder=""
                                spellcheck="false"></textarea>
                            <small>Error message</small>
                        </div>
                    </div>
                    `
            }
        </div>
    </form>
    `;
}
export function evolucionForm() {
    return /*html*/ `
    <form id='form-main'>
        <div class="row mt-3">
            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="fecha_hora">Fecha y hora</label>
                    <input type="datetime-local" name="fecha_hora" id="fecha_hora" class="form-control" placeholder="" value="${
                        getFecha().date + " " + getFecha().time
                    }"/>
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
function getFecha() {
    var today = new Date();
    var year = today.getFullYear();
    var month = (today.getMonth() + 1).toString().padStart(2, "0");
    var day = today.getDate().toString().padStart(2, "0");
    var hours = today.getHours().toString().padStart(2, "0");
    var minutes = today.getMinutes().toString().padStart(2, "0");
    return {
        date: `${year}-${month}-${day}`,
        time: `${hours}:${minutes}`,
    };
}
