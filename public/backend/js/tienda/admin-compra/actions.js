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

/**
 * Formatea una fecha ISO (de la base de datos) a un formato legible.
 * @param {string} dateString - Fecha en formato ISO (ej: "2023-12-31").
 * @returns {string} - Fecha formateada (ej: "31/12/2023").
 */
export function __dateFormat(dateString) {
    if (!dateString) return 'N/A'; // Manejo de valores nulos

    const date = new Date(dateString);
    if (isNaN(date)) return dateString; // Si no es una fecha válida, retorna el original

    return date.toLocaleDateString('es-ES', { // Formato español
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });

    // Opción alternativa (personalizable):
    // return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
}
/**
 * Formatea un número como moneda.
 * @param {number} value - Valor numérico (ej: 1500.5).
 * @returns {string} - Valor formateado (ej: "$1,500.50").
 */
export function __currencyFormat(value) {
    if (isNaN(parseFloat(value))) return 'N/A'; // Manejo de valores no numéricos

    return new Intl.NumberFormat('es-BO', { // Formato pesos mexicanos
        style: 'currency',
        currency: 'BOB',
        minimumFractionDigits: 2
    }).format(value);

    // Opción alternativa (sin símbolo de moneda):
    // return new Intl.NumberFormat('es-ES').format(value);
}
