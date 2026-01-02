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
    </td>
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
export function __bgFormat(date) {
    if(date == null) return '<div class="d-flex justify-content-center">N/A</div>';
    return `
        <div class="d-flex px-2 py-1  justify-content-center">
            <span data-bs-toggle="tooltip" data-bs-original-title="${defineDateStatus(date).message}" class="text-white badge bg-gradient-${defineDateStatus(date).status} mb-0">
                ${date}
            </span>
        </div>
    `;
}
function defineDateStatus(date) {
    // Fecha actual
    const currentDate = new Date();
    // Convertir la fecha proporcionada en un objeto Date
    const targetDate = new Date(date);

    // Calcular la diferencia en días entre la fecha actual y la fecha objetivo
    const timeDifference = targetDate - currentDate; // en milisegundos
    const daysDifference = timeDifference / (1000 * 3600 * 24); // convertir a días
    console.log();


    // Comprobar las condiciones y devolver el color adecuado
    if (daysDifference <= 0) {
        // Si la fecha ya pasó (rojo)
        return {
            status: 'danger',
            message: 'Producto vencido'
        };
    } else if (daysDifference <= 7 && daysDifference > 0) {
        // Si la fecha es dentro de los próximos 7 días (amarillo)
        return {
            status: 'warning',
            message: 'Producto por vencer'
        };
    } else {
        // Si la fecha es más de una semana en el futuro (verde)
        return {
            status: 'success',
            message: 'Producto vigente'
        };
    }
}
