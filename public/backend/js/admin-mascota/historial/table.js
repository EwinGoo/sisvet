export function listData(data, elements, name = "") {
    // console.log(Array.isArray(data));
    // console.log(data);

    if (!Array.isArray(data) || !elements) {
        console.error("Argumentos inválidos para listHistorial");
        return;
    }
    const tableBody = elements.find("tbody");
    tableBody.empty();
    if (data.length === 0) {
        tableBody.append(
            `<tr><td colspan="7" class="text-center">
            <p class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">sin datos<p>
            </td></tr>`
        );
        return;
    }

    data.forEach((row, index) => {
        tableBody.append(
            name == "examen"
                ? createRow(row, index)
                : createRowTwo(row, index, name)
        );
    });

    // Reinicializar tooltips si estás usando Bootstrap
    $('[data-bs-toggle="tooltip"]').tooltip();
}

function createRow(data, index) {
    // const fecha = new Date(historial.created_at).toLocaleString();
    // const estado = getEstadoBadge(historial.estado);
    return /*html*/ `
        <tr class="text-center">
            <td >
                <div class="d-flex px-2 py-1">
                    <h6 class="mb-0 font-weight-normal text-sm">${
                        index + 1
                    }</h6>
                </div>
            </td>
            <td >
                <div class="d-flex px-2 py-1">
                    <span class="text-white badge bg-gradient-success mb-0">${
                        data.fecha
                    }</span>
                </div>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${
                    data.temperatura
                }</p>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${
                    data.frecuencia_cardiaca
                }</p>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${
                    data.frecuencia_respiratoria
                }</p>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${data.mucosa}</p>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${data.rc} seg</p>
            </td>
            <td class="text-sm">
            <!--
                <a data-action="edit" data-id="${
                    data.id_examen
                }" href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Editar registro">
                    <i class="material-icons text-warning position-relative text-lg">drive_file_rename_outline</i>
                </a>
                -->
                <a data-action="delete" data-id="${
                    data.id_examen
                }" href="javascript:;" class="ms-3" data-bs-toggle="tooltip" data-bs-original-title="Eliminar registro">
                    <i class="material-icons text-danger position-relative text-lg">delete</i>
                </a>
            </td>
        </tr>
    `;
}

function createRowTwo(data, index, name) {
    // Lista de posibles claves para "data-id"
    const possibleKeys = [
        "id_sintoma",
        "id_vacuna",
        "id_metodo",
        "id_diagnostico_presuntivo",
        "id_diagnostico_definitivo",
        "id_evolucion",
        "id_tratamiento",
    ];

    // Encuentra la clave existente en el objeto `data`
    const dynamicId = possibleKeys.find((key) => key in data) || null;

    return /*html*/ `
    <tr>
        <td>
            <div class="d-flex px-2 py-1">
                <h6 class="mb-0 font-weight-normal text-sm">${index + 1}</h6>
            </div>
        </td>
        <td>
            <div class="d-flex px-2 py-1">
                <span class="text-white badge bg-gradient-success mb-0">${
                    data.fecha || data.fecha_hora
                }</span>
            </div>
        </td>
        ${
            name == "metodo"
                ? /*html*/ `
            <td>
                <p class="text-sm font-weight-normal mb-0 text-wrap">
                    ${data.resultados ?? "-"}
                </p>
            </td>
            <td>
                <p class="text-sm text-center font-weight-normal mb-0">
                    ${data.nombre_examen ?? "-"}
                </p>
            </td>
            <td>
                ${__imageLoad(data.ruta_archivo)}
            </td>
            `
                : /*html*/ `
            <td>
                <p class="text-sm font-weight-normal mb-0 text-wrap">${
                    name === "vacunas" ? data.nombre_vacuna ?? "" : data.descripcion ?? ""
                }</p>
            </td>
            `
        }
        <td class="text-sm">
            <!--<a data-action="edit" data-id="${
                data[dynamicId]
            }" href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Editar registro">
                <i class="material-icons text-warning position-relative text-lg">drive_file_rename_outline</i>
            </a>-->
            <a data-action="delete" data-id="${
                data[dynamicId]
            }" href="javascript:;" class="ms-3" data-bs-toggle="tooltip" data-bs-original-title="Eliminar registro">
                <i class="material-icons text-danger position-relative text-lg">delete</i>
            </a>
        </td>
    </tr>
`;
}
function __imageLoad(url = null) {

    if(!url) url = '/assets/images/no-image.jpg'
    else url =  `/storage/${url}`;

    return `
    <div class="d-flex px-2 py-1">
        <div>
            <img src="${url}" class="avatar avatar-md avatar-2 me-3 img-preview" alt="table image" />
        </div>
    </div>
    `;
}
