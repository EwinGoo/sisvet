import {
    anamnesisForm,
    examenForm,
    genericForm,
    evolucionForm,
} from "./forms.js";

$(document).ready(function () {
    let modalEl = $("#modal-main"),
        modalSize = $("#modal-size"),
        modalContent = $("#modal-content"),
        modalTitle = $("#modal-title"),
        form = $("#modal-main"),
        btnNew = $("#btn-new"),
        btnSubmit = $("#btn-submit");

    function optionChange(option = null) {
        // Limpiar el contenido modal existente
        modalContent.empty();

        // Objeto que mapea opciones a funciones de formulario y títulos
        const formOptions = {
            anamnesis: { generator: anamnesisForm, title: "Anamnesis", size: "lg" },
            examen: { generator: examenForm, title: "Examen", size: "lg" },
            sintomas: { generator: genericForm, title: "Síntomas", size: "md" },
            diagnostico: { generator: genericForm, title: "Diagnóstico", size: "md" },
            tratamiento: { generator: genericForm, title: "Tratamiento", size: "md" },
            evolucion: { generator: evolucionForm, title: "Evolución", size: "md" }
        };

        // Si la opción existe en nuestro mapa, genera el formulario correspondiente
        if (formOptions.hasOwnProperty(option)) {
            const { generator, title, size } = formOptions[option];
            const formHtml = generator();
            modalContent.html(formHtml);
            modalTitle.text(title);
            modalSize.removeClass("modal-lg modal-md").addClass(`modal-${size}`);
            initializeForm(option);
        } else {
            console.log("Opción no reconocida:", option);
        }
    }

    function initializeForm(formType) {
        const formUrls = {
            anamnesis: "/admin/anamnesis",
            examen: "/admin/examen",
            sintomas: "/admin/sintomas",
            diagnostico: "/admin/diagnostico",
            tratamiento: "/admin/tratamiento",
            evolucion: "/admin/evolucion"
        };
        // Aquí puedes agregar lógica específica para cada tipo de formulario
        switch (formType) {
            case "anamnesis":
                // Inicialización específica para anamnesis
                break;
            case "examen":
                break;
            case "sintomas":
                break;
            case "diagnostico":
                break;
            case "tratamiento":
                break;
            case "evolucion":
                // Inicialización específica para examen
                break;
            // ... otros casos según sea necesario
        }

        btnSubmit.off("click").on("click", function (e) {
            e.preventDefault();
            
            let formData = form.serialize();
            
            $.ajax({
                url: formUrls[formType],
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log("Formulario enviado con éxito:", formType);
                    // Aquí puedes manejar la respuesta exitosa
                    modalEl.modal("hide");
                    // Opcional: mostrar un mensaje de éxito
                    alert("Datos guardados correctamente");
                },
                error: function(xhr, status, error) {
                    console.error("Error al enviar el formulario:", formType, error);
                    // Aquí puedes manejar el error
                    alert("Error al guardar los datos. Por favor, intente de nuevo.");
                }
            });
        });
    }

    // Manejar el clic en el botón "New"
    $(document).on("click", ".new", function (e) {
        let option = $(this).data("action");
        modalEl.modal("show");
        optionChange(option);
    });

    // Puedes agregar más manejadores de eventos aquí si es necesario
});
