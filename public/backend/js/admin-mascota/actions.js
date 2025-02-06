export function ACTIONS(name = "", id = null) {
    return `
    <td class="text-sm">
        <!--<a href="javascript:;" data-bs-toggle="tooltip"
            data-bs-original-title="Vista previa de ${name}">
            <i class="material-icons text-info position-relative text-lg">visibility</i>
        </a>-->
        <a data-id="${id}" href="javascript:;" class="edit" data-bs-toggle="tooltip"
            data-bs-original-title="Editar ${name}">
            <i class="material-icons text-warning position-relative text-lg">drive_file_rename_outline</i>
        </a>
        <a data-id="${id}" href="javascript:;" class="ms-3 delete" data-bs-toggle="tooltip"
            data-bs-original-title="Eliminar ${name}">
            <i class="material-icons text-danger position-relative text-lg">delete</i>
        </a>
        <form class="d-inline historial" id="form-historial" action="/admin/mascota/historial" method="POST">
            <input type="hidden" id="input-mascota-id" name="id_mascota" value="${id}">
            <button type="button" class="ms-3 btn btn-sm btn-info" data-bs-toggle="tooltip"
            data-bs-original-title="Historial ${name}">HISTORIAL</button>
        </form>
    </td>
    `;
}
export function __imageLoad(url = null) {

    if(!url) url = '/assets/images/silueta-dog-cat.jpg'
    else url =  `/storage/${url}`;

    return `
    <div class="d-flex px-2 py-1">
        <div>
            <img src="${url}" class="avatar avatar-md me-3 img-preview" alt="table image" />
        </div>
    </div>
    `;
}

export function listHistorial(historiales, elements) {
    if (!Array.isArray(historiales) || !elements || !elements.modalHistorial) {
        console.error("Argumentos inválidos para listHistorial");
        return;
    }
    const tableBody = elements.modalHistorial.find("tbody");
    tableBody.empty();
    if (historiales.length === 0) {
        tableBody.append(
            '<tr><td colspan="4" class="text-center">No hay historiales disponibles</td></tr>'
        );
        return;
    }

    historiales.forEach((historial, index) => {
        tableBody.append(
            createHistorialRow(historial, index, historiales.length)
        );
    });

    // Reinicializar tooltips si estás usando Bootstrap
    $('[data-bs-toggle="tooltip"]').tooltip();
}
export function changeSelect(data,) {

}

function createHistorialRow(historial, index, length) {
    const fecha = new Date(historial.created_at).toLocaleString();
    const estado = getEstadoBadge(historial.estado);
    return `
        <tr>
            <td>
                <div class="d-flex px-2 py-1">
                    <h6 class="mb-0 font-weight-normal text-sm">${
                        length - index
                    }</h6>
                </div>
            </td>
            <td>
                <div class="d-flex px-2 py-1">
                    <span class="text-white badge bg-gradient-success mb-0">${fecha}</span>
                </div>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${estado}</p>
            </td>
            <td>
                <a href="/admin/mascota/${historial.id_historial}/historial"
                   class="btn btn-sm btn-info m-0"
                   data-bs-toggle="tooltip"
                   data-bs-original-title="Revisar historial"
                   target='_blank'>
                    <i class="material-icons position-relative text-lg">visibility</i> Revisar
                </a>
            </td>
        </tr>
    `;
}

function getEstadoBadge(estado) {
    const badgeClasses = {
        1: "badge-warning",
        2: "badge-success",
    };

    const badgeClass = badgeClasses[estado.toUpperCase()] || "badge-info";
    return `<span class="badge ${badgeClass}">${
        estado == 1 ? "ACTIVO" : "TERMINADO"
    }</span>`;
}
