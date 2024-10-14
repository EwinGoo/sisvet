import { ACTIONS, listHistorial } from "./actions.js";

$(document).ready(function () {
    const MascotaManager = {
        elements: {
            form: $("#form-main"),
            formHistorial: $("#form-historial"),
            modalEl: $("#modal-main"),
            modalHistorial: $("#modal-historial"),
            modalTitle: $("#modal-title"),
            btnNewHistorial: $("#new-historial"),
            btnNew: $("#btn-new"),
            btnSubmit: $("#btn-submit"),
            dataTable: $("#datatable"),
            inputMascotaId: $("#input-mascota-id"),
        },
        currentId: null,

        init() {
            this.initDataTable();
            this.bindEvents();
            utilities.initChoice();
            utilities.formValidateInit();
            utilities.ajaxSetup();
        },

        initDataTable() {
            this.table = this.elements.dataTable.DataTable({
                order: [[0, "desc"]],
                responsive: true,
                language: {
                    searchPlaceholder: "Buscar...",
                },
                lengthMenu: [
                    [5, 25, 50, -1],
                    [10, 25, 50, "Todos"],
                ],
                pagingType: "full_numbers",
                ajax: {
                    url: "/admin/mascota",
                },
                columns: [
                    // {
                    //     data: null,
                    //     targets: 0,
                    //     orderable: true,
                    //     render: (data, type, row, meta) => meta.row + 1
                    // },
                    { data: "id_mascota" },
                    { data: "nombre_mascota" },
                    { data: "nombre_completo" },
                    { data: "animal" },
                    {
                        data: null,
                        targets: -1,
                        orderable: false,
                        render: (data, type, row) =>
                            ACTIONS("mascota", row.id_mascota),
                    },
                ],
                drawCallback: () => {
                    utilities.tooltip();
                    utilities.loaderTool();
                },
            });
        },

        bindEvents() {
            this.elements.dataTable.on(
                "click",
                ".edit",
                this.handleEdit.bind(this)
            );
            this.elements.dataTable.on(
                "click",
                ".delete",
                this.handleDelete.bind(this)
            );
            this.elements.dataTable.on(
                "click",
                ".historial",
                this.handleHistorial.bind(this)
            );
            this.elements.btnNew.on("click", this.handleNew.bind(this));
            this.elements.btnSubmit.on("click", this.handleSubmit.bind(this));
        },

        handleEdit(event) {
            const id = $(event.currentTarget).data("id");
            this.editMascota(id);
        },

        handleDelete(event) {
            const id = $(event.currentTarget).data("id");
            az.showSwal("warning-message-delete", `/admin/mascota/${id}`);
        },
        handleHistorial(event) {
            const id = $(event.currentTarget).data("id");
            setTimeout(() => {
                this.elements.modalHistorial.modal("show");
            }, 100);
            this.elements.inputMascotaId.val(id);
            this.elements.btnNewHistorial.off("click").on("click", (e) => {
                e.preventDefault();
                this.submitHistorialForm();
            });
            // listHistorial(id, this.elements);
            this.loadHistoriales(id);
        },
        submitHistorialForm() {
            $.ajax({
                url: this.elements.formHistorial.attr("action"),
                method: "POST",
                data: this.elements.formHistorial.serialize(),
                success: (response) => {
                    if (response.redirectUrl) {
                        // Abrir nueva pestaña con la URL de redirección
                        window.open(response.redirectUrl, "_blank");
                        // Recargar los historiales en la pestaña actual
                        // this.loadHistoriales(this.elements.inputMascotaId.val());
                        this.loadHistoriales(response.id_mascota);
                    }
                },
                error: (xhr) => {
                    console.error(
                        "Error al crear nuevo historial:",
                        xhr.responseText
                    );
                    this.showError(
                        "Error",
                        "No se pudo crear el nuevo hist orial. Por favor, intente de nuevo."
                    );
                },
            });
        },
        loadHistoriales(id) {
            $.ajax({
                url: `/admin/mascota/historiales/${id}`,
                method: "GET",
                dataType: "json",
                success: (response) => {
                    if (response) {
                        console.log(response);
                        listHistorial(response.data, this.elements);
                        // this.listHistorial(response.historiales);
                    } else {
                        console.error(
                            "Respuesta inesperada del servidor",
                            response
                        );
                    }
                },
                error: (xhr, status, error) => {
                    console.error("Error al cargar historiales:", error);
                },
            });
        },

        handleNew() {
            this.resetForm();
            this.elements.modalTitle.text("Nueva mascota");
            this.elements.btnSubmit.removeAttr("data-id");
            this.elements.modalEl.modal("show");
        },

        handleSubmit() {
            this.elements.btnSubmit.prop("disabled", true);
            const url = this.currentId
                ? `/admin/mascota/${this.currentId}`
                : "/admin/mascota";
            const method = this.currentId ? "PUT" : "POST";
            this.saveRegister(url, method);
        },

        editMascota(id) {
            const mascota = utilities.getByID(id, this.table, "id_mascota");
            console.log(mascota);

            this.populateForm(mascota);
            this.elements.modalTitle.text("Editar mascota");
            this.elements.btnSubmit.prop("disabled", false);
            this.currentId = id;
            this.elements.modalEl.modal("show");
        },

        populateForm(mascota) {
            this.elements.form.find(":input").each(function () {
                const $input = $(this);
                const name = $input.attr("name");
                if ($input.prop("tagName") === "SELECT") {
                    const choice = choiceInstances.find(
                        (element) => element._baseId === `choices--${name}`
                    );
                    if (choice) choice.setChoiceByValue(`${mascota[name]}`);
                } else {
                    $input.val(mascota[name]).parent().addClass("is-filled");
                }
            });
        },

        resetForm() {
            utilities.resetForm(this.elements.form);
            this.elements.btnSubmit.prop("disabled", false);
        },

        saveRegister(url, method) {
            $.ajax({
                type: method,
                url,
                data: this.elements.form.serialize(),
                success: (response) => {
                    this.elements.modalEl.modal("hide");
                    this.table.ajax.reload();
                    az.showSwal("success-message", null, response.message);
                },
                error: (xhr) => {
                    this.elements.btnSubmit.prop("disabled", false);
                    utilities.formValidation(xhr.responseJSON.errors);
                },
            });
        },
        showError(title, message) {
            // Swal.fire({
            //     icon: "error",
            //     title: title,
            //     text: message,
            //     confirmButtonText: "Entendido",
            //     confirmButtonColor: "#3085d6",
            //     customClass: {
            //         confirmButton: "btn btn-primary",
            //     },
            // });
            console.log("error");
        },
    };

    MascotaManager.init();
});
