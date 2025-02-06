import {
    anamnesisForm,
    examenForm,
    getForm,
    evolucionForm,
    metodoForm,
} from "./forms.js";
import { anamnesisChange } from "./data.js";
import { listData } from "./table.js";

$(document).ready(function () {
    const MascotaManager = {
        elements: {
            currentOption: "",
            modalEl: $("#modal-main"),
            modalSize: $("#modal-size"),
            modalContent: $("#modal-content"),
            modalTitle: $("#modal-title"),
            currentId: $("#profile").data("id"),
            btnNew: $("#btn-new"),
            btnSubmit: $("#btn-submit"),
            dataTable: $("#datatable"), // Asumiendo que tienes una tabla
            toast: $("#infoToast"), // Asumiendo que tienes una tabla
            toastMessage: $("#infoToast div:last"), // Asumiendo que tienes una tabla
            tables: {
                examen: $("#table-examen"),
                vacunas: $("#table-vacunas"),
                sintomas: $("#table-sintomas"),
                metodos_complementarios: $("#table-metodos-complementarios"),
                diagnosticos_presuntivos: $("#table-diagnostico-presuntivo"),
                diagnosticos_definitivos: $("#table-diagnostico-definitivo"),
                tratamiento: $("#table-tratamiento"),
                evolucion: $("#table-evolucion"),
            },
        },
        data: {
            tipos_vacunas: [],
            anamnesis: [],
            vacunas: [],
            examen: [],
            sintomas: [],
            metodos_complementarios: [],
            diagnosticos_presuntivos: [],
            diagnosticos_definitivos: [],
            tratamiento: [],
            evolucion: [],
        },

        formOptions: {
            anamnesis: {
                generator: anamnesisForm,
                title: "Anamnesis",
                size: "lg",
                id: "id_historial",
            },
            vacunas: {
                generator: getForm,
                title: "Vacunas",
                size: "md",
                id: "id_vacuna",
            },
            examen: {
                generator: examenForm,
                title: "Examen",
                size: "lg",
                id: "id_examen",
            },
            sintomas: {
                generator: getForm,
                title: "Síntomas",
                size: "md",
                id: "id_sintoma",
            },
            metodos_complementarios: {
                generator: metodoForm,
                title: "Metodos Complementarios",
                size: "md",
                id: "id_metodo",
            },
            diagnosticos_presuntivos: {
                generator: getForm,
                title: "Diagnóstico Presuntivo",
                size: "md",
                id: "id_diagnostico_presuntivo",
            },
            diagnosticos_definitivos: {
                generator: getForm,
                title: "Diagnóstico Definitivo",
                size: "md",
                id: "id_diagnostico_definitivo",
            },
            tratamiento: {
                generator: getForm,
                title: "Tratamiento",
                size: "md",
                id: "id_tratamiento",
            },
            evolucion: {
                generator: evolucionForm,
                title: "Evolución",
                size: "md",
                id: "id_evolucion",
            },
        },

        formUrls: {},

        init() {
            // $("[data-action='metodos_complementarios']").click();
            // $("[data-action='metodos_complementarios']")[0].click();
            this.bindEvents();
            utilities.ajaxSetup();
            this.loadInitialData();
            this.formUrls = {
                anamnesis: `/admin/mascota/${this.elements.currentId}/historial/anamnesis`,
                vacunas: `/admin/mascota/${this.elements.currentId}/historial/vacunas`,
                examen: `/admin/mascota/${this.elements.currentId}/historial/examen`,
                sintomas: `/admin/mascota/${this.elements.currentId}/historial/sintomas`,
                metodos_complementarios: `/admin/mascota/${this.elements.currentId}/historial/metodos_complementarios`,
                diagnosticos_presuntivos: `/admin/mascota/${this.elements.currentId}/historial/diagnosticos_presuntivos`,
                diagnosticos_definitivos: `/admin/mascota/${this.elements.currentId}/historial/diagnosticos_definitivos`,
                tratamiento: `/admin/mascota/${this.elements.currentId}/historial/tratamiento`,
                evolucion: `/admin/mascota/${this.elements.currentId}/historial/evolucion`,
            };
        },
        fetchSectionData(option) {
            console.log(this.formUrls[option]);

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: this.formUrls[option],
                    method: "GET",
                    success: (response) => {
                        resolve(response); // Resolvemos la promesa con la respuesta
                    },
                    error: (error) => {
                        reject(error); // Rechazamos la promesa en caso de error
                    },
                });
            });
        },
        updateSpecificSection(option, data) {
            const sectionHandlers = {
                anamnesis: () => this.loadAnamnesis(data),
                vacunas: () => this.loadVacunas(data),
                examen: () => this.loadExamenGeneral(data),
                sintomas: () => this.loadSintomas(data),
                metodos_complementarios: () =>
                    this.loadMetodosComplemetarios(data),
                diagnosticos_presuntivos: () =>
                    this.loadDiagnosticoPresuntivo(data),
                diagnosticos_definitivos: () =>
                    this.loadDiagnosticoDefinitivo(data),
                tratamiento: () => this.loadTratamiento(data),
                evolucion: () => this.loadEvolucion(data),
            };

            sectionHandlers[option]?.();
        },
        loadInitialData() {
            const id_historial = this.elements.currentId;
            $.ajax({
                url: `/admin/mascota/${id_historial}/historial`,
                method: "GET",
                success: (response) => {
                    this.data = { ...this.data.data, ...response };
                    // console.log(this.data);

                    this.loadAnamnesis(this.data.data);
                    this.loadVacunas(this.data.data.vacunas);
                    this.loadExamenGeneral(this.data.data.examen);
                    this.loadSintomas(this.data.data.sintomas);
                    this.loadMetodosComplemetarios(
                        this.data.data.metodos_complementarios
                    );
                    this.loadDiagnosticoPresuntivo(
                        this.data.data.diagnosticos_presuntivos
                    );
                    this.loadDiagnosticoDefinitivo(
                        this.data.data.diagnosticos_definitivos
                    );
                    this.loadEvolucion(this.data.data.evolucion);
                    this.loadTratamiento(this.data.data.tratamiento);
                    // this.updateUI();
                },
                error: (xhr, status, error) => {
                    console.error(
                        "Error al cargar los datos iniciales:",
                        error
                    );
                    // Mostrar mensaje de error al usuario
                },
            });
        },
        loadAnamnesis(data) {
            const anamnesis = data.anamnesis || data;
            this.data.data.anamnesis = anamnesis;
            const values = { ...anamnesis };

            $("#ult_des").text(values.ultima_desparasitacion);
            $("#vac").text(values.vacunas);
            $("#tra_rec").text(values.tratamientos_recientes);
            $("#enf_ant").text(values.enfermedades_anteriores);
        },
        loadVacunas(data) {
            listData(data, this.elements.tables.vacunas, "vacunas");
        },

        loadExamenGeneral(data) {
            // console.log(data.examen);
            // console.log(this.data.data.anamnesis.inspeccion);
            // setTimeout(() => {
            $("#inspeccion-info").text(this.data.data.anamnesis.inspeccion);
            $("#palpacion-info").text(this.data.data.anamnesis.palpacion);
            // }, 2000);
            // $("#inspeccion-info").text('asd');
            // $("#palpacion-info").text('asd');
            listData(data, this.elements.tables.examen, "examen");
        },
        loadSintomas(data) {
            listData(data, this.elements.tables.sintomas);
        },
        loadMetodosComplemetarios(data) {
            // console.log(Object.keys(data));
            listData(
                data,
                this.elements.tables.metodos_complementarios,
                "metodo"
            );
        },
        loadDiagnosticoPresuntivo(data) {
            listData(data, this.elements.tables.diagnosticos_presuntivos);
        },
        loadDiagnosticoDefinitivo(data) {
            listData(data, this.elements.tables.diagnosticos_definitivos);
        },
        loadTratamiento(data) {
            listData(data, this.elements.tables.tratamiento);
        },
        loadEvolucion(data) {
            listData(data, this.elements.tables.evolucion);
        },

        bindEvents() {
            $(document).on("click", ".new", this.handleNew.bind(this));
            // $(document).on("click", "[data-action='edit']", this.handleEdit.bind(this));
            $(document).on(
                "click",
                "[data-action='delete']",
                this.handleDelete.bind(this)
            );
            this.elements.btnSubmit.on("click", this.handleSubmit.bind(this));
        },
        handleNew(e) {
            let option = $(e.currentTarget).data("action");
            this.elements.modalEl.modal("show");
            this.optionChange(option);
        },
        handleEdit(e) {
            const id = $(e.currentTarget);
            const option = $(e.currentTarget).closest("table").data("type");
            this.elements.modalEl.modal("show");
            this.optionChange(option, id);
        },

        handleDelete(e) {
            const id = $(e.currentTarget).data("id");
            const option = $(e.currentTarget).closest("table").data("type");

            if (confirm("¿Está seguro de eliminar este registro?")) {
                $.ajax({
                    url: `${this.formUrls[option]}/${id}`,
                    type: "DELETE",
                    success: (response) => {
                        this.showToast(response.message);
                        console.log(this.data.data[option]);

                        this.data.data[option] = this.data.data[option].filter(
                            (item) => item[this.formOptions[option].id] !== id
                        );
                        this.updateSpecificSection(
                            option,
                            this.data.data[option]
                        );
                    },
                    error: this.handleError,
                });
            }
        },
        handleError(xhr) {
            const errorMessages = Object.values(xhr.responseJSON.errors)
                .map(
                    (value) =>
                        `<span class="text-danger text-md">${value[0]}</span><br>`
                )
                .join("");
            az_new.showSwal({ e: "errors", message: errorMessages });
        },
        optionChange(option, id = null) {
            this.elements.modalContent.empty();
            if (this.formOptions.hasOwnProperty(option)) {
                const { generator, title, size } = this.formOptions[option];
                const formHtml =
                    option === "vacunas"
                        ? generator(1, this.data.data.tipos_vacunas)
                        : generator();
                this.elements.currentOption = option;
                this.elements.modalContent.html(formHtml);
                this.elements.modalTitle.text("Agregar " + title);
                this.elements.modalSize
                    .removeClass("modal-lg modal-md")
                    .addClass(`modal-${size}`);
                this.initializeForm(option);
            } else {
                console.log("Opción no reconocida:", option);
            }
            if (id) {
                $.ajax({
                    url: `${this.formUrls[option]}/${id}`,
                    type: "GET",
                    success: (response) => {
                        Object.keys(response.data).forEach((key) => {
                            $(`#${key}`).val(response.data[key]);
                        });
                    },
                });
            }
        },

        initializeForm(formType) {
            utilities.initChoice(false);
            switch (formType) {
                case "anamnesis":
                    // console.log('yes');
                    anamnesisChange(this.elements, this.data);
                    break;
                case "vacunas":
                    break;
                case "examen":
                    $("#palpacion").val(this.data.data.anamnesis.palpacion);
                    $("#inspeccion").val(this.data.data.anamnesis.inspeccion);
                    // Inicialización específica para examen
                    break;
                case "sintomas":
                case "metodos_complementarios":
                    const imageUploader = new ImageUploader();
                    // Inicialización específica para examen
                    break;
                // ... otros casos según sea necesario
            }
            if (this.data[formType] && this.data[formType].length > 0) {
                // Ejemplo: pre-llenar el último registro
                const lastRecord =
                    this.data[formType][this.data[formType].length - 1];
                Object.keys(lastRecord).forEach((key) => {
                    $(`#${key}`).val(lastRecord[key]);
                });
            }
        },
        handleSubmit(e) {
            e.preventDefault();
            this.elements.btnSubmit.prop("disabled", true);
            let formData = new FormData(
                this.elements.modalContent.find("form")[0]
            );
            formData.append("id_historial", this.elements.currentId);
            formData.append("option", this.elements.currentOption);
            // let formData = this.elements.modalContent.find("form").serialize();
            // formData += "&id_historial=" + this.elements.currentId;
            // formData += "&option=" + this.elements.currentOption;

            $.ajax({
                url: this.formUrls[this.elements.currentOption],
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    // console.log(response);

                    this.elements.modalEl.modal("hide");
                    this.showToast(response.message);
                    this.updateLocalData(
                        this.elements.currentOption,
                        response.data,
                        response.type
                    );
                    this.elements.btnSubmit.prop("disabled", false);
                },
                error: (xhr, status, error) => {
                    let data = "";
                    Object.values(xhr.responseJSON.errors).forEach((value) => {
                        data += `<span class="text-danger text-md">${value[0]}</span><br>`;
                    });
                    az_new.showSwal({ e: "errors", message: data });
                    this.elements.btnSubmit.prop("disabled", false);
                },
            });
        },
        updateLocalData(dataType, newData, type = null) {
            if (dataType === "anamnesis" || type === "anamnesis") {
                // console.log(dataType,newData);
                this.data.data.anamnesis = newData;
            } else {
                const idField =
                    this.formOptions[this.elements.currentOption].id;
                const existingIndex = this.data.data[dataType].findIndex(
                    (item) => item[idField] === newData[idField]
                );

                if (existingIndex !== -1) {
                    this.data.data[dataType][existingIndex] = newData;
                } else {
                    this.data.data[dataType].push(newData);
                }
            }
            this.updateSpecificSection(
                dataType,
                this.data.data[this.elements.currentOption]
            );
        },
        showToast(message) {
            this.elements.toastMessage.text(message);
            new bootstrap.Toast(this.elements.toast, { delay: 2500 }).show();
        },
    };

    MascotaManager.init();
});
