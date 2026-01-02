import { _ACTIONS, _ESTADO, __imageLoad } from "./actions.js";
$(document).ready(function () {
    const UserManager = {
        elements: {
            csrf: $('meta[name="csrf-token"]'),
            form: $("#form-main"),
            modalEl: $("#modal-main"),
            modalTitle: $("#modal-title"),
            btnNew: $("#btn-new"),
            btnSubmit: $("#btn-submit"),
            dataTable: $("#datatable"),
            password: $("#password"),
            passwordConfirm: $("#password_confirmation"),
            changeField: $("#change-field"),
            btnChange: $("#change"),
        },
        currentId: null,

        init() {
            utilities.initChoice();
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
                    url: "/admin/usuario",
                },
                columns: [
                    { data: "id_usuario" },
                    {
                        data: null,
                        targets: 1,
                        orderable: false,
                        render: (data, type, row) =>
                            __imageLoad(row.ruta_archivo),
                        createdCell: function (td) {
                            td.style.padding = "0.3rem 1.5rem"; // Establece el padding en 0
                        },
                    },
                    {
                        data: null,
                        targets: 1,
                        orderable: false,
                        render: (data, type, row) => {
                            return (
                                row.nombre +
                                " " +
                                row.paterno +
                                " " +
                                (row.materno || "")
                            );
                        },
                    },
                    { data: "usuario" },
                    { data: "rol" },
                    {
                        data: null,
                        targets: -1,
                        orderable: false,
                        render: (data, type, row) =>
                            _ESTADO(row.id_usuario, row.estado),
                    },
                    {
                        data: null,
                        targets: -1,
                        orderable: false,
                        render: (data, type, row) =>
                            _ACTIONS("usuario", row.id_usuario),
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
                ".state",
                this.handleStateChange.bind(this)
            );
            this.elements.btnNew.on("click", this.handleNew.bind(this));
            this.elements.btnSubmit.on("click", this.handleSubmit.bind(this));
            this.elements.btnChange.on(
                "click",
                this.handlePasswordFieldToggle.bind(this)
            );
            $("#image").on("click", () => {
                $("#error-image").text("");
                this.imgState = true;
            });
            $("#rol-area").on("click", () => $("#error-rol").text(""));
        },

        handleEdit(event) {
            const id = $(event.currentTarget).data("id");
            this.editUser(id);
        },

        handleDelete(event) {
            const id = $(event.currentTarget).data("id");
            az.showSwal("warning-message-delete", `/admin/usuario/${id}`);
        },

        handleStateChange(event) {
            const userId = $(event.currentTarget).data("id");
            const state = $(event.currentTarget).data("state");
            const message = !state
                ? "¿Quieres activar la cuenta?"
                : "¿Quieres desactivar la cuenta?";

            Swal.fire({
                title: "Confirmación",
                text: message,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.updateUserState(userId);
                }
            });
        },

        handleNew() {
            this.resetForm();
            this.elements.modalTitle.text("nuevo usuario");
            this.setRoleValues();
            this.elements.changeField.hide();
            this.enablePasswordFields();

            // pond.removeFiles();
        },

        handleSubmit() {
            this.elements.btnSubmit.prop("disabled", true);
            const url = this.currentId
                ? `/admin/usuario/${this.currentId}`
                : "/admin/usuario";
            const method = this.currentId ? "PUT" : "POST";
            this.saveRegister(url, method);
        },

        handlePasswordFieldToggle() {
            this.enablePasswordFields();
        },

        async editUser(id) {
            const user = utilities.getByID(id, this.table, "id_usuario");
            const url = user.ruta_archivo && "/storage/" + user.ruta_archivo;
            this.resetForm();
            console.log(user);

            this.populateForm(user);
            this.elements.modalTitle.text("editar usuario");
            this.elements.btnSubmit.prop("disabled", false);
            this.currentId = id;
            this.elements.modalEl.modal("show");
            this.setRoleValues();
            this.elements.changeField.show();
            this.disablePasswordFields();
            // console.log(url);

            imageUploader.loadImageFromURL(url);
        },

        populateForm(user) {
            this.elements.form.find(":input").each(function () {
                const $input = $(this);
                const name = $input.attr("name");
                if ($input.is(":radio")) {
                    console.log(name);

                    console.log(user[name]);


                    $input.prop(
                        "checked",
                        user[name]?.toString() === $input.val()
                    );

                    console.log(user[name],$input.val());
                } else {
                    $input.val(user[name]).parent().addClass("is-filled");
                }
            });
            utilities.reloadStyle();
        },

        resetForm() {
            utilities.resetForm(this.elements.form);
            this.elements.btnSubmit.prop("disabled", false);
            this.currentId = null;
            imageUploader.removeImage();
        },

        setRoleValues() {
            $("#administrador").val("1");
            $("#medico").val("2");
            $("#vendedor").val("3");
        },

        enablePasswordFields() {
            this.elements.password.prop("disabled", false);
            this.elements.passwordConfirm.prop("disabled", false);
        },

        disablePasswordFields() {
            this.elements.password.prop("disabled", true);
            this.elements.passwordConfirm.prop("disabled", true);
        },

        async getUserImage(id) {
            try {
                const response = await $.ajax({
                    type: "GET",
                    url: `/admin/usuario/${id}/image`,
                });
                return response.image;
            } catch (error) {
                throw new Error(error.responseJSON.message);
            }
        },

        updateUserState(userId) {
            $.ajax({
                url: "/admin/change-state-user",
                method: "POST",
                data: { id: userId },
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
            // const files = pond.getFiles();

            // if (files.length === 1 && this.imgState) {
            //     formData.append("image", files[0].file);
            // } else {
            //     formData.delete("image");
            // }

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
                    $("#error-rol").text(xhr.responseJSON.errors.rol);
                },
            });
        },
    };

    UserManager.init();
});
