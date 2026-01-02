import { _ACTIONS, _ESTADO } from "./actions.js";
$(document).ready(function () {
    const RazaManager = {
        elements: {
            csrf: $('meta[name="csrf-token"]'),
            form: $("#form-main"),
            modalEl: $("#modal-main"),
            modalTitle: $("#modal-title"),
            btnNew: $("#btn-new"),
            btnSubmit: $("#btn-submit"),
            dataTable: $("#datatable"),
        },
        currentId: null,

        init() {
            utilities.initChoice(true);
            this.initDataTable();
            this.bindEvents();
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
                    url: "/admin/raza",
                },
                columns: [
                    { data: "id_raza" },
                    { data: "raza" },
                    { data: "nombre_animal" },
                    {
                        data: "descripcion",
                        render: function (data) {
                            return data || "Sin descripción";
                        },
                    },
                    // {
                    //     data: null,
                    //     targets: -1,
                    //     orderable: false,
                    //     render: (data, type, row) =>
                    //         _ESTADO(row.id_raza, row.estado),
                    // },
                    {
                        data: null,
                        targets: -1,
                        orderable: false,
                        render: (data, type, row) =>
                            _ACTIONS("raza", row.id_raza),
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
            // this.elements.dataTable.on(
            //     "click",
            //     ".state",
            //     this.handleStateChange.bind(this)
            // );
            this.elements.btnNew.on("click", this.handleNew.bind(this));
            this.elements.btnSubmit.on("click", this.handleSubmit.bind(this));
        },

        handleEdit(event) {
            const id = $(event.currentTarget).data("id");
            this.editRaza(id);
        },

        handleDelete(event) {
            const id = $(event.currentTarget).data("id");
            az.showSwal("warning-message-delete", `/admin/raza/${id}`);
        },

        // handleStateChange(event) {
        //     const id = $(event.currentTarget).data("id");
        //     const state = $(event.currentTarget).data("state");
        //     const message = !state
        //         ? "¿Quieres activar esta raza?"
        //         : "¿Quieres desactivar esta raza?";

        //     Swal.fire({
        //         title: "Confirmación",
        //         text: message,
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonText: "Sí",
        //         cancelButtonText: "No",
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             this.updateRazaState(id);
        //         }
        //     });
        // },

        handleNew() {
            this.resetForm();
            this.currentId = null;
            this.elements.modalTitle.text("Nueva Raza");
            this.elements.btnSubmit.prop("disabled", false);
        },

        handleSubmit() {
            this.elements.btnSubmit.prop("disabled", true);
            const url = this.currentId
                ? `/admin/raza/${this.currentId}`
                : "/admin/raza";
            const method = this.currentId ? "PUT" : "POST";
            this.saveRegister(url, method);
        },

        async editRaza(id) {
            const raza = utilities.getByID(id, this.table, "id_raza");
            this.resetForm();
            this.populateForm(raza);
            this.elements.modalTitle.text("Editar Raza");
            this.elements.btnSubmit.prop("disabled", false);
            this.currentId = id;
            this.elements.modalEl.modal("show");
        },

        populateForm(raza) {
            this.elements.form.find(":input").each(function () {
                const $input = $(this);
                const name = $input.attr("name");
                $input.val(raza[name]).parent().addClass("is-filled");
            });
            const choice = choiceInstances['id_animal'];
            console.log(choice);

            console.log(raza['id_animal']);
                        // console.log(choice);/
            if (choice) choice.setChoiceByValue((raza['id_animal'] || "").toString());
            utilities.reloadStyle();
        },

        resetForm() {
            utilities.resetForm(this.elements.form);
            this.elements.btnSubmit.prop("disabled", false);
            this.currentId = null;
        },

        updateRazaState(id) {
            $.ajax({
                url: "/admin/change-state-raza",
                method: "POST",
                data: { id: id },
                success: (response) => {
                    Swal.fire("¡Hecho!", response.message, "success");
                    this.table.ajax.reload();
                },
                error: () => {
                    Swal.fire(
                        "Error",
                        "Ocurrió un error al intentar cambiar el estado.",
                        "error"
                    );
                },
            });
        },

        saveRegister(url, method) {
            const formData = new FormData(this.elements.form[0]);
            formData.append("_method", method);

            $.ajax({
                type: "POST",
                url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    this.elements.modalEl.modal("hide");
                    this.table.ajax.reload();
                    az.showSwal("success-message", null, response.message);
                    this.elements.btnSubmit.prop("disabled", false);
                },
                error: (xhr) => {
                    this.elements.btnSubmit.prop("disabled", false);
                    utilities.formValidation(xhr.responseJSON.errors);
                },
            });
        },
    };

    RazaManager.init();
});
