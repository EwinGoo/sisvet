import { ACTIONS } from "../../components/actions.js";

class ProveedorManager {
    constructor() {
        this.form = $("#form-main");
        this.modalEl = $("#modal-main");
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
            order: [[0, "desc"]],
            responsive: true,
            language: languageTable,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, "Todos"],
            ],
            pagingType: "full_numbers",
            ajax: { url: "/admin/proveedor" },
            columns: [
                { data: "id_proveedor" },
                { data: "nombre" },
                { data: "contacto" },
                { data: "celular" },
                { data: "correo" },
                {
                    data: null,
                    targets: -1,
                    orderable: false,
                    render: (data, type, row) =>
                        ACTIONS("proveedor", row.id_proveedor),
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
    }

    initializeUtilities() {
        utilities.formValidateInit();
        utilities.ajaxSetup();
    }

    handleNewClick() {
        this.resetForm("Nuevo Proveedor");
    }

    handleEdit(e) {
        const target = $(e.target).closest(".edit");
        const id = target.data("id");
        this.editForm(id, "Editar Proveedor");
    }

    handleDelete(e) {
        const target = $(e.target).closest(".delete");
        const id = target.data("id");
        az.showSwal("warning-message-delete", `/admin/proveedor/${id}`);
    }

    handleSubmit() {
        this.btnSubmit.prop("disabled", true);
        const url = this.currentId
            ? `/admin/proveedor/${this.currentId}`
            : "/admin/proveedor";
        const method = this.currentId ? "PUT" : "POST";
        this.saveRegister(url, method);
    }

    resetForm(title) {
        this.modalTitle.text(title);
        this.btnSubmit.removeAttr("data-id");
        utilities.resetForm(this.form);
        this.btnSubmit.prop("disabled", false);
        this.currentId = null;
    }

    editForm(id, title) {
        const reg = utilities.getByID(id, this.table, "id_proveedor");
        this.currentId = id;
        this.modalTitle.text(title);
        this.modalEl.modal("show");
        utilities.reloadStyle();
        this.populateForm(reg);
    }

    populateForm(data) {
        this.form.find(":input").each(function () {
            const name = $(this).attr("name");
            $(this).parent().addClass("is-filled");
            $(this).val(data[name]);
        });
    }

    saveRegister(url, method) {
        let dataForm = new FormData(this.form[0]);
        dataForm.append("_method", method);

        $.ajax({
            type: "POST",
            url: url,
            data: dataForm,
            contentType: false,
            processData: false,
            success: (response) => this.handleSaveSuccess(response),
            error: (error) => this.handleSaveError(error),
        });
    }

    handleSaveSuccess(response) {
        this.btnSubmit.prop("disabled", false);
        this.modalEl.modal("hide");
        this.table.ajax.reload();
        az.showSwal("success-message", null, response.message);
    }

    handleSaveError(error) {
        this.btnSubmit.prop("disabled", false);
        const errors = error.responseJSON.errors;
        utilities.formValidation(errors);
    }
}

$(document).ready(() => new ProveedorManager());
