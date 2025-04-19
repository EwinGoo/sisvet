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
            <div class="col-12 col-sm-6 mt-sm-2 mt-3">
                <label for="mucosa">Mucosa</label>
                <div class="input-group input-group-outline" id="select-validation-mucosa">
                    <select class="form-control choices" name="mucosa" id="mucosa">
                        <option value="">[SELECCIONE]</option>
                        <option value="Congestiva">Congestiva</option>
                        <option value="Cianotico">Cianotico</option>
                        <option value="Icterico">Icterico</option>
                        <option value="Anemico">Anemico</option>
                        <option value="Normal">Normal</option>
                    </select>
                    <small class="select-error" error-name="mucosa">Error message</small>
                </div>
            </div>
            <div class="col-6 col-sm-6 mt-sm-2 mt-3">
                <!--<div class="input-group input-group-static">
                    <label for="rc">R.S. SEG</label>
                    <input type="text" name="rc" id="rc" class="form-control" placeholder="" />
                </div>-->
                <label for="rc">R.C. SEG</label>
                <div class="input-group input-group-outline" id="select-validation-rc">
                    <select class="form-control choices" name="rc" id="rc">
                        <option value="">[SELECCIONE]</option>
                        <option value="1">1 Seg</option>
                        <option value="2">2 Seg</option>
                        <option value="3">3 Seg</option>
                    </select>
                    <small class="select-error" error-name="rc">Error message</small>
                </div>
            </div>
            <div class="form-check p-0 mt-4 w-auto" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
            aria-controls="collapseExample">
                <label class="form-check-label text-warning" for="isUpdateTwoFields">
                    ¿Actualizar los campos inspección y palpación?
                </label>
                <input type="checkbox" class="form-check-input" name="isUpdateTwoFields" id="isUpdateTwoFields" />
            </div>
            <div class="collapse" id="collapseExample">
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
        </div>
    </form>
    `;
}
export function getForm(typeField = 0, tiposVacunas = []) {
    // Template para campos de examen/resultados
    const metodosFields = /*html*/ `
        <div class="col-12 col-sm-12 mt-3">
            <label for="examen" class="form-control ms-0 mb-0">Examen</label>
            <div class="input-group input-group-static az-input-group-outline">
                <textarea id="examen" name="examen" class="form-control az-area p-3" rows="2"></textarea>
                <small>Error message</small>
            </div>
        </div>
        <div class="col-12 col-sm-12 mt-3">
            <label for="resultados" class="form-control ms-0 mb-0">Resultados</label>
            <div class="input-group input-group-static az-input-group-outline">
                <textarea id="resultados" name="resultados" class="form-control az-area p-3" rows="2"></textarea>
                <small>Error message</small>
            </div>
        </div>`;

    // Template para campos clínicos
    const vacunasOptions = tiposVacunas
        .map(
            (tv) =>
                `<option value="${tv.id_tipo_vacuna}">${tv.nombre_vacuna}</option>`
        )
        .join("");

    const vacunasFields = /*html*/ `
        <div class="col-12 col-sm-12 mt-sm-2 mt-3">
            <label for="id_tipo_vacuna">Tipo de vacuna</label>
            <div class="input-group input-group-outline" id="select-validation-id_tipo_vacuna">
                <select class="form-control choices" name="id_tipo_vacuna" id="id_tipo_vacuna">
                    <option value="">[SELECCIONE]</option>
                    ${vacunasOptions}
                </select>
                <small class="select-error" error-name="id_tipo_vacuna">Error message</small>
            </div>
        </div>`;

    // Template para descripción
    const descripcionField = /*html*/ `
        <div class="col-12 col-sm-12 mt-3">
            <label for="descripcion" class="form-control ms-0 mb-0">Descripción</label>
            <div class="input-group input-group-static az-input-group-outline">
                <textarea id="descripcion" name="descripcion" class="form-control az-area p-3" rows="2"></textarea>
                <small>Error message</small>
            </div>
        </div>`;

    return /*html*/ `
    <form id='form-main'>
        <div class="row mt-3">
            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="${
                        getFecha().date
                    }" />
                </div>
            </div>
            ${
                typeField === 1
                    ? vacunasFields
                    : typeField === 2
                    ? metodosFields
                    : descripcionField
            }
        </div>
    </form>`;
}
export function metodoForm() {
    return /*html*/ `
    <form id='form-main' enctype="multipart/form-data">
        <div class="row mt-3">
            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                <div class="input-group input-group-static">
                    <label for="fecha_hora">Fecha y hora</label>
                    <input type="datetime" name="fecha_hora" id="fecha_hora" class="form-control" placeholder="" value="${
                        getFecha().date
                    }"/>
                </div>
            </div>
            <div class="col-12 col-sm-12 mt-3">
                <label for="examen" class="form-control ms-0 mb-0">Examen</label>
                <div class="input-group input-group-static az-input-group-outline">
                    <textarea id="examen" name="examen" class="form-control az-area p-3" rows="2"></textarea>
                    <small>Error message</small>
                </div>
            </div>
            <div class="col-12 col-sm-12 mt-3">
                <label for="resultados" class="form-control ms-0 mb-0">Resultados</label>
                <div class="input-group input-group-static az-input-group-outline">
                    <textarea id="resultados" name="resultados" class="form-control az-area p-3" rows="2"></textarea>
                    <small>Error message</small>
                </div>
            </div>
            <div class="col-12 col-sm-12 mt-3 ">
                <label for="id_tipo_examen">Tipo de examen</label>
                <div class="input-group input-group-outline" id="select-validation-id_tipo_examen">
                    <select class="form-control choices" name="id_tipo_examen" id="id_tipo_examen">
                        <option value="">[SELECCIONE]</option>
                        <option value="1">Hemograma</option>
                        <option value="2">Quimica Sanguinea</option>
                        <option value="3">Perfil hepatico</option>
                        <option value="4">Perfil renal</option>
                        <option value="5">Perfil pancreatico</option>
                        <option value="6">Ecografia</option>
                        <option value="7">Radiografia</option>
                    </select>
                    <small class="select-error" error-name="id_tipo_examen">Error message</small>
                </div>
            </div>
            <div class="col-12 col-sm-12 mb-2 mt-3">
                <label class="form-control ms-0 p-0">Imagen:</label>
                <div class="image-uploader h-0 m-0 w-100 w-sm-50 m-auto">
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
