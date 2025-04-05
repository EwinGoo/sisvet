export function _ACTIONS(name = "", id = null) {
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
    </td>
    `;
}

export function _ESTADO(id, state = null) {
    return `
        <span data-id="${id}" data-state="${state}" class="badge badge-${
        state === "1" ? "success" : "secondary"
    } badge-md state">
            ${state === "1" ? "ACTIVO" : "INACTIVO"}
        </span>
    `;
}

export function __imageLoad(url = null) {
    if (!url) url = "/assets/images/no-image.png";
    else url = `/storage/${url}`;

    return `
    <div class="d-flex px-2 py-1">
        <div>
            <img src="${url}"
                class="avatar avatar-md me-3 img-preview" alt="table image" />
        </div>
    </div>
    `;
}
