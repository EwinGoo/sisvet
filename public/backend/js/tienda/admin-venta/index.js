import { ACTIONS } from "./actions.js";

class ClientManager {
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
            lengthMenu: [[5, 25, 50, -1], [10, 25, 50, "Todos"]],
            pagingType: "full_numbers",
            ajax: { url: "/admin/venta" },
            columns: [
                { data: "id_venta" },
                { data: "vendedor" },
                { data: "cliente" },
                { data: "fecha" },
                { data: "hora" },
                { data: "total_venta" },
                {
                    data: null,
                    targets: -1,
                    orderable: false,
                    render: (data, type, row) => ACTIONS("venta", row.id_venta)
                }
            ],
            drawCallback: () => {
                utilities.tooltip();
                utilities.loaderTool();
            }
        });
    }

    initializeEventListeners() {
        this.btnNew.on("click", () => this.handleNewClick());
        this.btnSubmit.on("click", () => this.handleSubmit());
        this.table.on("click", ".edit", (e) => this.handleEdit(e));
        this.table.on("click", ".delete", (e) => this.handleDelete(e));
    }

    initializeUtilities() {
        utilities.initChoice();
        utilities.formValidateInit();
        utilities.ajaxSetup();
    }

    handleNewClick() {
        this.resetForm("nueva venta");
    }

    handleEdit(e) {
        const id = $(e.target).data("id");
        this.editForm(id,'editar venta');
    }

    handleDelete(e) {
        const target = $(e.target).closest('.delete');
        const id = target.data("id");
        az.showSwal("warning-message-delete", `/admin/venta/${id}`);
    }

    handleSubmit() {
        this.btnSubmit.prop("disabled", true);
        const url = this.currentId ? `/admin/propietario/${this.currentId}` : "/admin/propietario";
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

    editForm(id,title) {
        this.currentId = id;
              const reg = utilities.getByID(id, this.table, "id_propietario");
        this.modalEl.modal("show");
        utilities.reloadStyle();
        this.populateForm(reg);
    }

    populateForm(data) {
        this.form.find(":input").each(function() {
            const name = $(this).attr("name");
            if ($(this).prop("tagName") === "SELECT") {
                const choice = choiceInstances.find(el => el._baseId === `choices--${name}`);
                if (choice) choice.setChoiceByValue(data[name]);
            } else {
                $(this).parent().addClass("is-filled");
                $(this).val(data[name]);
            }
        });
    }

    saveRegister(url, method) {
        $.ajax({
            type: method,
            url,
            data: this.form.serialize(),
            success: (response) => this.handleSaveSuccess(response),
            error: (error) => this.handleSaveError(error)
        });
    }

    handleSaveSuccess(response) {
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

$(document).ready(() => new ClientManager());