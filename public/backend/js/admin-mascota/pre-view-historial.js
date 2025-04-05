export function getHistorial(data) {
    $("#propietario").text(data.anamnesis?.nombre_completo || "");
    $("#celular").text(data.anamnesis?.celular || "");
    $("#direccion").text(data.anamnesis?.direccion || "");

    // Datos de la mascota
    console.log(data.anamnesis?.nombre_mascota);

    $("#nombre_mascota_text").text(data.anamnesis?.nombre_mascota || "");
    $("#especie").text(data.anamnesis?.animal || "");
    $("#edad").text(formatearEdad(data.anamnesis));
    // $("#sexo").text(data.anamnesis?.sexo || "");
    $("#peso").text(data.anamnesis?.peso || "");
    $("#color_text").text(data.anamnesis?.color || "");
    $("#raza").text(data.anamnesis?.raza || "");

    // Anamnesis
    $("#enfermedadades-anteriores").text(
        data.anamnesis?.enfermedades_anteriores || ""
    );
    $("#tratamientos-recientes").text(
        data.anamnesis?.tratamientos_recientes || ""
    );
    $("#ultima-desparasitacion").text(
        data.anamnesis?.ultima_desparasitacion || ""
    );
    $("#vacunas").text(data.anamnesis?.vacunas || "");

    // Examen general - tabla
    const $examenTbody = $("#data-examen tbody");
    $examenTbody.empty(); // Limpiar tabla antes de agregar datos

    if (data.examen && data.examen.length > 0) {
        data.examen.forEach((examen) => {
            const row = `
                <tr>
                    <td class="font-weight-normal text-sm">${
                        examen.fecha || ""
                    }</td>
                    <td class="font-weight-normal text-sm">${
                        examen.temperatura || ""
                    }</td>
                    <td class="font-weight-normal text-sm">${
                        examen.frecuencia_cardiaca || ""
                    }</td>
                    <td class="font-weight-normal text-sm">${
                        examen.frecuencia_respiratoria || ""
                    }</td>
                    <td class="font-weight-normal text-sm">${
                        examen.mucosa || ""
                    }</td>
                    <td class="font-weight-normal text-sm">${
                        examen.rc || ""
                    }</td>
                </tr>
            `;
            $examenTbody.append(row);
        });

        // Agregar inspección y palpación solo una vez al final, tomando los valores de anamnesis
        const inspeccionPalpacion = `
            <tr>
                <td class="text-dark font-weight-bolder text-sm">Inspección</td>
                <td colspan="5" class="font-weight-normal text-sm">${
                    data.anamnesis?.inspeccion || ""
                }</td>
            </tr>
            <tr>
                <td class="text-dark font-weight-bolder text-sm">Palpación</td>
                <td colspan="5" class="font-weight-normal text-sm">${
                    data.anamnesis?.palpacion || ""
                }</td>
            </tr>
        `;
        $examenTbody.append(inspeccionPalpacion);
    }

    // Síntomas - tabla
    const $sintomasTbody = $("#data-sintomas tbody");
    $sintomasTbody.empty();

    if (data.sintomas && data.sintomas.length > 0) {
        data.sintomas.forEach((sintoma) => {
            const row = `
                <tr>
                    <td class="font-weight-normal text-sm">${
                        sintoma.fecha || ""
                    }</td>
                    <td class="font-weight-normal text-sm" colspan="5">${
                        sintoma.descripcion || ""
                    }</td>
                </tr>
            `;
            $sintomasTbody.append(row);
        });
    }

    // Métodos complementarios - tabla
    const $metodosTbody = $("#data-metodos-complementarios tbody");
    $metodosTbody.empty();

    if (
        data.metodos_complementarios &&
        data.metodos_complementarios.length > 0
    ) {
        data.metodos_complementarios.forEach((metodo) => {
            const row = `
                <tr>
                    <td class="font-weight-normal text-sm">${
                        metodo.fecha_hora || ""
                    }</td>
                    <td class="font-weight-normal text-sm" colspan="5">${
                        metodo.examen || ""
                    }</td>
                    <td class="font-weight-normal text-sm" colspan="5">${
                        metodo.resultados || ""
                    }</td>
                    <td class="font-weight-normal text-sm" colspan="5">${
                        metodo.nombre_examen || ""
                    }</td>
                </tr>
            `;
            $metodosTbody.append(row);
        });
    }

    // Diagnósticos presuntivos - tabla
    const $diagnosticosPresuntivosTbody = $(
        "#data-diagnosticos-presuntivos tbody"
    );
    $diagnosticosPresuntivosTbody.empty();

    if (
        data.diagnosticos_presuntivos &&
        data.diagnosticos_presuntivos.length > 0
    ) {
        data.diagnosticos_presuntivos.forEach((diagnostico) => {
            const row = `
                <tr>
                    <td class="font-weight-normal text-sm">${
                        diagnostico.fecha || ""
                    }</td>
                    <td class="font-weight-normal text-sm" colspan="5">${
                        diagnostico.descripcion || ""
                    }</td>
                </tr>
            `;
            $diagnosticosPresuntivosTbody.append(row);
        });
    }

    // Diagnósticos definitivos - tabla
    const $diagnosticosDefinitivosTbody = $(
        "#data-diagnosticos-definitivos tbody"
    );
    $diagnosticosDefinitivosTbody.empty();

    if (
        data.diagnosticos_definitivos &&
        data.diagnosticos_definitivos.length > 0
    ) {
        data.diagnosticos_definitivos.forEach((diagnostico) => {
            const row = `
                <tr>
                    <td class="font-weight-normal text-sm">${
                        diagnostico.fecha || ""
                    }</td>
                    <td class="font-weight-normal text-sm" colspan="5">${
                        diagnostico.descripcion || ""
                    }</td>
                </tr>
            `;
            $diagnosticosDefinitivosTbody.append(row);
        });
    }

    // Evolución y pronóstico - tabla
    const $evolucionTbody = $("#data-evolucion tbody");
    $evolucionTbody.empty();

    if (data.evolucion && data.evolucion.length > 0) {
        data.evolucion.forEach((evol) => {
            const row = `
                <tr>
                    <td class="font-weight-normal text-sm">${
                        evol.fecha_hora || ""
                    }</td>
                    <td class="font-weight-normal text-sm" colspan="5">${
                        evol.descripcion || ""
                    }</td>
                </tr>
            `;
            $evolucionTbody.append(row);
        });
    }
}

function formatearEdad(anamnesisData) {
    if (
        !anamnesisData ||
        (anamnesisData.years === 0 && anamnesisData.meses === 0)
    ) {
        return ""; // Si no hay datos o es 0 años y 0 meses, retorna vacío
    }

    const { years, meses } = anamnesisData;
    let edadTexto = "";

    if (years > 0) {
        edadTexto += `${years} año${years !== 1 ? "s" : ""}`;
    }

    meses && years ? (edadTexto += " y ") : (edadTexto += "");

    if (meses > 0) {
        if (years > 0) edadTexto += " "; // Espacio si ya hay años
        edadTexto += `${meses} mes${meses !== 1 ? "es" : ""}`;
    }

    return edadTexto;
}
