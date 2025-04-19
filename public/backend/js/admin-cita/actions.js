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
        <a data-id="${id}" href="javascript:;" class="ms-3 btn btn-sm btn-info cambiar-estado" data-bs-toggle="tooltip"
            data-bs-original-title="Cambiar estado">
            <i class="material-icons position-relative text-lg">sync_alt</i>
        </a>
    </td>
    `;
}

// <button class="btn btn-sm btn-info cambiar-estado" data-id="${
//     row.id_cita
// }"
//     data-tooltip="Cambiar estado" data-bs-toggle="modal" data-bs-target="#modal-estado">
//     <i class="fas fa-exchange-alt"></i>
// </button>

/**
 * Formatea una fecha/hora en un formato legible
 * @param {string|Date} dateTime - Fecha/hora a formatear (puede ser string ISO o objeto Date)
 * @param {string} locale - Configuración regional (por defecto 'es-ES')
 * @param {Object} options - Opciones adicionales de formato
 * @returns {string} Fecha/hora formateada
 */
export function __dateTimeFormat(dateTime, locale = "es-ES", options = {}) {
    if (!dateTime) return "--/--/---- --:--";

    const defaultOptions = {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: false, // Formato 24 horas
    };

    const mergedOptions = { ...defaultOptions, ...options };

    try {
        // Si es string, convertirlo a Date
        const dateObj =
            typeof dateTime === "string" ? new Date(dateTime) : dateTime;

        // Validar si es una fecha válida
        if (isNaN(dateObj.getTime())) {
            console.error("Fecha inválida:", dateTime);
            return "--/--/---- --:--";
        }

        return __bgDate(dateObj.toLocaleString(locale, mergedOptions));
    } catch (error) {
        console.error("Error al formatear fecha:", error);
        return "--/--/---- --:--";
    }
}

/**
 * Formatea un estado con colores e iconos apropiados
 * @param {string} status - Estado a formatear
 * @param {Object} config - Configuración personalizada de estados
 * @returns {string} HTML con el estado formateado
 */
export function __statusFormat(status, config = {}) {
    if (!status) return '<span class="text-muted">Sin estado</span>';

    // Configuración por defecto para estados comunes
    const defaultConfig = {
        Pendiente: {
            class: "warning",
            icon: "schedule",
            text: "Pendiente",
        },
        Confirmada: {
            class: "info",
            icon: "check_circle",
            text: "Confirmada",
        },
        Completada: {
            class: "success",
            icon: "done_all",
            text: "Completada",
        },
        Cancelada: {
            class: "danger",
            icon: "cancel",
            text: "Cancelada",
        },
        // Puedes agregar más estados según necesites
    };

    // Combinar con configuración personalizada
    const statusConfig = { ...defaultConfig, ...config };

    // Obtener configuración para el estado o usar valores por defecto si no existe
    const currentStatus = statusConfig[status] || {
        class: "secondary",
        icon: "fas fa-question-circle",
        text: status,
    };
    // <i class="${currentStatus.icon} me-1"></i>

    return `
        <span class="d-flex align-items-center justify-content-center badge badge-sm bg-gradient-${currentStatus.class}">
            <span class="material-icons me-1">
                ${currentStatus.icon}
            </span>
            ${currentStatus.text}
        </span>
    `;
}

function __bgDate(date) {
    return `
        <span class="badge badge-md bg-gradient-success">
            <i class="${date} me-1"></i>
            ${date}
        </span>
    `;
}

export function __infoFormat(data, row) {
    const mensaje = encodeURIComponent(
        `¡Hola ${data}! 😊\nSomos de la *Clínica Veterinaria San Martín* 🐶🐾\n\nEstamos para atenderte.`
    );

    return `
        ${data}<br>
        <small>${row.celular}</small>
        <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0"
           href="https://api.whatsapp.com/send?phone=${row.celular}&text=${mensaje}"
           target="_blank"
           style="margin-left: 5px;">
           <img src="/assets/images/whatsapp.svg" width="20" alt="WhatsApp">
        </a>
    `;
}
