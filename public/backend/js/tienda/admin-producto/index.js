import { ACTIONS, __bgFormat, __imageLoad } from "../../components/actions.js";

class ClientManager {
    constructor() {
        this.form = $("#form-main");
        this.modalEl = $("#modal-main");
        this.modalTitle = $("#modal-title");
        this.btnNew = $("#btn-new");
        this.btnSubmit = $("#btn-submit");
        this.table = null;
        this.currentId = null;
        this.dataSelect = null;
        this.initializeDataTable();
        this.initChoices();
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
            ajax: { url: "/admin/producto" },
            columns: [
                { data: "id_producto" },
                {
                    data: null,
                    targets: 1,
                    orderable: false,
                    render: (data, type, row) => __imageLoad(row.ruta_archivo),
                    createdCell: function (td) {
                        td.style.padding = "0.3rem 1.5rem"; // Establece el padding en 0
                    },
                },
                { data: "nombre_producto" },
                {
                    data: null,
                    targets: -1,
                    orderable: true,
                    render: (data, type, row) => row.precio + " Bs.",
                },
                {
                    data: null,
                    targets: -1,
                    orderable: true,
                    render: (data, type, row) =>
                        __bgFormat(row.fecha_vencimiento),
                },
                {
                    data: null,
                    targets: -1,
                    orderable: false,
                    render: (data, type, row) =>
                        ACTIONS("producto", row.id_producto),
                },
            ],
            drawCallback: () => {
                utilities.tooltip();
                utilities.loaderTool();
            },
        });
    }

    initChoices() {
        // this.queryFetch('admin/producto/create','GET', this.dataSelect);
        // $('.choice name=[categiras]')
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
        this.resetForm("nuevo producto");
    }

    handleEdit(e) {
        const target = $(e.target).closest(".edit");
        const id = target.data("id");
        this.editForm(id, "editar producto");
    }

    handleDelete(e) {
        const target = $(e.target).closest(".delete");
        const id = target.data("id");
        az.showSwal("warning-message-delete", `/admin/producto/${id}`);
    }

    handleSubmit() {
        this.btnSubmit.prop("disabled", true);
        const url = this.currentId
            ? `/admin/producto/${this.currentId}`
            : "/admin/producto";
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
        const reg = utilities.getByID(id, this.table, "id_producto");
        console.log(reg);

        const url = reg.ruta_archivo && "/storage/" + reg.ruta_archivo;
        this.currentId = id;
        this.modalTitle.text(title);
        this.modalEl.modal("show");
        utilities.reloadStyle();
        this.populateForm(reg);

        imageUploader.loadImageFromURL(url);
    }

    populateForm(data) {
        this.form.find(":input").each(function () {
            const name = $(this).attr("name");
            if ($(this).prop("tagName") === "SELECT") {
                const choice = choiceInstances[name];
                if (choice)
                    choice.setChoiceByValue(data[name].toString() || "");
            } else {
                $(this).parent().addClass("is-filled");
                $(this).val(data[name]);
            }
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
    queryFetch(url, method, data) {
        $.ajax({
            type: method,
            url,
            success: (response) => (data = response.data),
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
        console.log(errors);

        utilities.formValidation(errors);
    }
}

$(document).ready(() => new ClientManager());
