export function listData(data, elements, name = '') {
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

    data.forEach((row,index) => {
        tableBody.append(
            name == 'examen' ? createRow(row, index): createRowTwo(row, index, name)
        );
    });

    // Reinicializar tooltips si estás usando Bootstrap
    // $('[data-bs-toggle="tooltip"]').tooltip();
}

function createRow(data, index) {
    // const fecha = new Date(historial.created_at).toLocaleString();
    // const estado = getEstadoBadge(historial.estado);
    return /*html*/`
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
                    <span class="text-white badge bg-gradient-success mb-0">${data.fecha}</span>
                </div>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${data.temperatura}</p>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${data.frecuencia_cardiaca}</p>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${data.frecuencia_respiratoria}</p>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${data.mucosa}</p>
            </td>
            <td>
                <p class="text-sm font-weight-normal mb-0">${data.rc}</p>
            </td>
        </tr>
    `;
}
function createRowTwo(data, index, name) {
    // console.log({data,index});

    return /*html*/`
        <tr>
            <td>
                <div class="d-flex px-2 py-1">
                    <h6 class="mb-0 font-weight-normal text-sm">${index + 1}</h6>
                </div>
            </td>
            <td>
                <div class="d-flex px-2 py-1">
                    <span class="text-white badge bg-gradient-success mb-0">${data.fecha || data.fecha_hora}</span>
                </div>
            </td>
            ${
                name == 'metodo' ?
                /*html*/`
                <td>
                    <p class="text-sm font-weight-normal mb-0">${data.examen ?? ''}</p>
                </td>
                <td>
                    <p class="text-sm font-weight-normal mb-0">${data.resultados ?? ''}</p>
                </td>
                `:
                /*html*/`
                <td>
                    <p class="text-sm font-weight-normal mb-0">${data.descripcion}</p>
                </td>
                `
            }
        </tr>
    `;
}
