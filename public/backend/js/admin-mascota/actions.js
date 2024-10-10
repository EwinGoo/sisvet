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
        <a data-id="${id}" class="ms-3 btn btn-sm btn-info historial" data-bs-toggle="tooltip"
            data-bs-original-title="Historial ${name}" target='_blank'>
            HISTORIAL
        </a>
    </td>
    `;
}

export function listHistorial(historiales, elements) {
    if (!Array.isArray(historiales) || !elements || !elements.modalHistorial) {
        console.error("Argumentos inválidos para listHistorial");
        return;
    }
    const tableBody = elements.modalHistorial.find('tbody');
    tableBody.empty();
    if (historiales.length === 0) {
        tableBody.append('<tr><td colspan="3" class="text-center">No hay historiales disponibles</td></tr>');
        return;
    }

    historiales.forEach(historial => {
        tableBody.append(createHistorialRow(historial));
    });

    // Reinicializar tooltips si estás usando Bootstrap
    $('[data-bs-toggle="tooltip"]').tooltip();
}

function createHistorialRow(historial) {
    const fecha = new Date(historial.fecha).toLocaleString();
    const estado = getEstadoBadge(historial.estado);

    return `
        <tr>
            <td>
                <div class="d-flex px-2 py-1">
                    <h6 class="mb-0 font-weight-normal text-sm">${fecha}</h6>
                </div>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${estado}</p>
            </td>
            <td>
                <a href="/admin/historial/${historial.id}" 
                   class="btn btn-sm btn-info m-0" 
                   data-bs-toggle="tooltip"
                   data-bs-original-title="Ver Historial" 
                   target='_blank'>
                    <i class="material-icons position-relative text-lg">visibility</i> Revisar
                </a>
            </td>
        </tr>
    `;
}

function getEstadoBadge(estado) {
    const badgeClasses = {
        'ACTIVO': 'badge-success',
        'PENDIENTE': 'badge-warning',
        'CERRADO': 'badge-secondary'
    };

    const badgeClass = badgeClasses[estado.toUpperCase()] || 'badge-info';
    return `<span class="badge ${badgeClass}">${estado}</span>`;
}
