import { ACTIONS, __dateTimeFormat, __statusFormat, __infoFormat } from "./actions.js";

class CitaManager {
    constructor() {
        this.form = $("#form-main");
        this.formEstado = $("#form-estado");
        this.modalEl = $("#modal-main");
        this.modalEstadoEl = $("#modal-estado");
        this.modalTitle = $("#modal-title");
        this.btnNew = $("#btn-new");
        this.btnSubmit = $("#btn-submit");
        this.table = null;
        this.currentId = null;
        this.initializeDataTable();
        this.initializeEventListeners();
        this.initializeUtilities();
    }

    initializeDataTable() {
        this.table = $("#datatable").DataTable({
            order: [[1, "desc"]],
            responsive: true,
            language: languageTable,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"],
            ],
            pagingType: "full_numbers",
            ajax: {
                url: "/admin/cita",
            },
            columns: [
                { data: "id_cita" },
                {
                    data: "fecha_hora",
                    render: (data) => __dateTimeFormat(data),
                },
                {
                    data: null,
                    render: (data) =>
                        `${data.nombre_mascota} (${data.especie})`,
                },
                {
                    data: "nombre_propietario",
                    render: (data, type, row) => __infoFormat(data,row),
                },
                { data: "tipo_consulta" },
                {
                    data: "nombre_medico",
                    render: (data) =>
                        data || '<span class="text-muted">Sin asignar</span>',
                },
                {
                    data: "estado",
                    render: (data) => __statusFormat(data),
                },
                {
                    data: null,
                    targets: -1,
                    orderable: false,
                    render: (data, type, row) => `
                        ${ACTIONS("cita", row.id_cita, false)}

                    `,
                },
            ],
            drawCallback: () => {
                utilities.tooltip();
                utilities.loaderTool();
            },
        });
    }

    initializeEventListeners() {
        this.btnNew.on("click", () => this.handleNewClick());
        this.btnSubmit.on("click", () => this.handleSubmit());
        this.table.on("click", ".edit", (e) => this.handleEdit(e));
        this.table.on("click", ".delete", (e) => this.handleDelete(e));
        this.table.on("click", ".cambiar-estado", (e) =>
            this.handleCambiarEstado(e)
        );
        // Enviar formulario de estado
        this.formEstado.on("submit", (e) => this.handleEstadoSubmit(e));
    }

    initializeUtilities() {
        utilities.initChoice();
        utilities.formValidateInit();
        utilities.ajaxSetup();
        setTimeout(() => {
            this.setupChoiceListeners();
        }, 300);
    }

    setupChoiceListeners() {
        // Verificar si existe la instancia Choice para id_propietario
        // console.log(choiceInstances["id_propietario"]);

        if (choiceInstances && choiceInstances["id_propietario"]) {
            const propietarioChoice = choiceInstances["id_propietario"];

            // Usar el evento nativo de Choice.js
            propietarioChoice.passedElement.element.addEventListener(
                "choice",
                (event) => {
                    const selectedValue = event.detail.choice.value;
                    this.loadMascotas(selectedValue);

                    // Resetear raza si es necesario
                    if (choiceInstances["id_mascota"]) {
                        const razaChoice = choiceInstances["id_mascota"];
                        razaChoice.setChoices(
                            [{ value: "", label: "Mascota", disabled: true }],
                            "value",
                            "label",
                            true
                        );
                        razaChoice.setChoiceByValue("");
                    }
                },
                false
            );
        } else {
            console.warn("Choice instance for id_propietario not found");

            // Fallback a evento change normal si Choice no está disponible
            $("#id_propietario").on("change", (e) => {
                this.loadMascotas($(e.target).val());
            });
        }

        if (choiceInstances && choiceInstances["estado"]) {
            const estado = choiceInstances["estado"];
            estado.passedElement.element.addEventListener(
                "choice",
                (event) => {
                    const selectedValue = event.detail.choice.value;
                    // console.log(selectedValue);
                    if ("Cancelada" === selectedValue) {
                        $("#motivo-cancelacion-container").show();
                    }
                },
                false
            );
        }
    }

    handleNewClick() {
        this.resetForm("nueva cita");
        this.modalEl.modal("show");
        this.btnSubmit.prop("disabled", false);
    }

    handleEdit(e) {
        const target = $(e.target).closest(".edit");
        const id = target.data("id");
        this.editForm(id, "editar cita");
    }

    handleDelete(e) {
        const target = $(e.target).closest(".delete");
        const id = target.data("id");
        az.showSwal("warning-message-delete", `/admin/cita/${id}`);
    }

    handleCambiarEstado(e) {
        const target = $(e.target).closest(".cambiar-estado");
        const id = target.data("id");
        this.currentId = id;
        const estadoChoice = choiceInstances["estado"];
        estadoChoice.setChoiceByValue("Confirmada");
        this.modalEstadoEl.modal("show");
        $("#estado-cita-id").val(id);
        $("#modal-estado-title").text(`Cambiar estado - Cita #${id}`);
        // this.formEstado.trigger("reset");

        $("#motivo-cancelacion-container").hide();
    }

    handleEstadoSubmit(e) {
        e.preventDefault();
        const btnSubmit = this.formEstado.find("button[type='submit']");
        btnSubmit.prop("disabled", true);

        $.ajax({
            type: "POST",
            url: `/admin/cita/${this.currentId}/cambiar-estado`,
            data: this.formEstado.serialize(),
            success: (response) => {
                this.modalEstadoEl.modal("hide");
                this.table.ajax.reload();
                az.showSwal("success-message", null, response.message);
            },
            error: (error) => {
                const motivoField = $('[name="motivo_cancelacion"]');
                const parentDiv = motivoField.closest(".input-group");
                showError(
                    $('[name="motivo_cancelacion"]')[0],
                    error.responseJSON.errors.motivo_cancelacion[0]
                );

                setTimeout(() => {
                    parentDiv.removeClass("is-invalid");
                    errorElement.text("");
                }, 2000);
            },
            complete: () => {
                btnSubmit.prop("disabled", false);
            },
        });
    }

    handleSubmit() {
        this.btnSubmit.prop("disabled", true);
        const url = this.currentId
            ? `/admin/cita/${this.currentId}`
            : "/admin/cita";
        const method = this.currentId ? "PUT" : "POST";

        $.ajax({
            type: "POST",
            url: url,
            data: this.form.serialize() + `&_method=${method}`,
            success: (response) => {
                this.modalEl.modal("hide");
                this.table.ajax.reload();
                az.showSwal("success-message", null, response.message);
            },
            error: (error) => {
                // this.btnSubmit.prop("disabled", false);

                utilities.formValidation(error.responseJSON.errors);
            },
            complete: () => {
                this.btnSubmit.prop("disabled", false);
            },
        });
    }

    resetForm(title) {
        this.modalTitle.text(title);
        utilities.resetForm(this.form);
        this.currentId = null;
        const idMascotaChoice = choiceInstances["id_mascota"]; // Asegúrate de que este sea el identificador correcto
        if (idMascotaChoice) {
            idMascotaChoice.clearChoices(); // Elimina las opciones existentes
            idMascotaChoice.setChoices(
                [
                    {
                        value: "",
                        label: "[SELECCIONE PROPIETARIO PRIMERO]",
                        selected: true,
                        disabled: true,
                    },
                ],
                "value",
                "label"
            );
        }
    }

    async editForm(id, title) {
        const cita = utilities.getByID(id, this.table, "id_cita");
        await this.loadMascotas(cita.id_propietario);
        this.populateForm(cita);
        this.modalTitle.text(title);
        this.btnSubmit.prop("disabled", false);
        this.currentId = id;
        this.modalEl.modal("show");
        // imageUploader.loadImageFromURL(url);
    }

    populateForm(cita) {
        console.log(cita);
        const form = this.form;

        // Primero llenar los selects con choices
        form.find("select.choices").each(function () {
            const $select = $(this);
            const name = $select.attr("name");
            const choice = choiceInstances[name];

            if (choice) {
                choice.setChoiceByValue((cita[name] || "").toString());
            }
        });

        // Luego llenar los demás campos
        form.find(":input")
            .not("select.choices")
            .each(function () {
                const $input = $(this);
                const name = $input.attr("name");

                if (name && cita[name] !== undefined) {
                    if ($input.is(":radio")) {
                        $input
                            .filter(`[value="${cita[name]}"]`)
                            .prop("checked", true);
                    } else {
                        $input.val(cita[name]);

                        // Agregar clase is-filled si tiene valor
                        if (cita[name]) {
                            $input.parent().addClass("is-filled");
                        }
                    }
                }
            });

        // Manejar campos datetime-local
        if (cita.fecha_hora) {
            const fechaHora = new Date(cita.fecha_hora);
            const formattedDate = fechaHora.toISOString().slice(0, 16);
            form.find("#fecha_hora").val(formattedDate);
        }
    }

    async loadMascotas(id_propietario) {
        if (!id_propietario) {
            return;
        }
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `/admin/mascota/get-mascotas/${id_propietario}`,
                method: "GET",
                success: (response) => {
                    console.log(response);

                    const mascotaChoice = choiceInstances["id_mascota"];
                    if (mascotaChoice) {
                        mascotaChoice.clearChoices();
                        if (response.mascotas) {
                            response.mascotas.forEach((mascota) => {
                                mascotaChoice.setChoices([
                                    {
                                        value: mascota.id_mascota.toString(),
                                        label:
                                            mascota.nombre_mascota +
                                            " - " +
                                            mascota.animal,
                                    },
                                ]);
                            });
                        }
                    }
                    resolve(); // Indica que la operación ha finalizado correctamente
                },
                error: (xhr) => {
                    console.error("Error loading razas:", xhr.responseText);
                    reject(xhr); // Indica que hubo un error
                },
            });
        });
    }
}

$(document).ready(() => new CitaManager());
