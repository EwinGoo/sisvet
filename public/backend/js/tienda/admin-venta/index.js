import { ACTIONS, updateModalDetails } from "./actions.js";

class ClientManager {
    constructor() {
        this.form = $("#form-main");
        this.modalEl = $("#modal-main");
        this.modalTitle = $("#modal-title");
        this.modalBody = $("#modal-body");
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
                    render: (data, type, row) => ACTIONS("venta", row.id_venta),
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
        // this.table.on("click", ".edit", (e) => this.handleEdit(e));
        this.table.on("click", ".delete", (e) => this.handleDelete(e));
        this.table.on("click", ".details", (e) => this.handleDetails(e));
    }

    initializeUtilities() {
        utilities.initChoice();
        utilities.formValidateInit();
        utilities.ajaxSetup();
    }

    handleDetails(e) {
        const target = $(e.target).closest(".details");
        const id = target.data("id");
        // this.editForm(id, "editar producto");
        this.showDetails(id);
    }

    handleNewClick() {
        this.resetForm("nueva venta");
    }

    handleEdit(e) {
        const id = $(e.target).data("id");
        this.editForm(id, "editar venta");
    }

    handleDelete(e) {
        const target = $(e.target).closest(".delete");
        const id = target.data("id");
        az.showSwal("warning-message-delete", `/admin/venta/${id}`);
    }

    handleSubmit() {
        this.btnSubmit.prop("disabled", true);
        const url = this.currentId
            ? `/admin/propietario/${this.currentId}`
            : "/admin/propietario";
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

    showDetails(id) {
        this.currentId = id;
        this.modalTitle.text("Detalle de Venta");

        // Mostrar el modal
        this.modalEl.modal("show");

        // Cargar los datos
        this.loadDetails(id);
    }
    loadDetails(id) {
        $.ajax({
            url: `/admin/venta/${id}/detalle`,
            method: "GET",
            beforeSend: () => {
                // Mostrar loader mientras carga
                this.modalBody.html(
                    '<div class="text-center py-4"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );
            },
            success: (response) => {
                if (response.status === 200) {
                    // Actualizar los campos del modal con los datos recibidos
                    updateModalDetails(this.modalBody, response.venta, response.detalles);
                } else {
                    this.modalBody.html(
                        '<div class="alert alert-danger">Error al cargar los detalles de la venta</div>'
                    );
                }
            },
            error: (error) => {
                this.modalBody.html(
                    '<div class="alert alert-danger">Error al cargar los detalles de la venta</div>'
                );
                console.error("Error:", error);
            },
        });
    }
    // updateModalDetails(venta, detalles) {
    //     // Actualizar información general
    //     $("#venta-id").text(venta.id_venta);
    //     $("#venta-fecha").text(venta.fecha);
    //     $("#venta-hora").text(venta.hora);
    //     $("#venta-vendedor").text(venta.vendedor);
    //     $("#venta-cliente").text(venta.cliente || "Sin cliente registrado");
    //     $("#venta-total").text(
    //         `${parseFloat(venta.total_venta).toFixed(2)} Bs.`
    //     );

    //     // Limpiar y actualizar tabla de productos
    //     const $tbody = $("#detalle-productos").empty();

    //     detalles.forEach((detalle) => {
    //         $tbody.append(`
    //             <tr>
    //                 <td class="text-sm">${detalle.nombre_producto}</td>
    //                 <td class="text-sm">${detalle.id_producto}</td>
    //                 <td class="text-sm">${detalle.cantidad}</td>
    //                 <td class="text-sm">${parseFloat(
    //                     detalle.precio_unitario
    //                 ).toFixed(2)} Bs.</td>
    //                 <td class="text-sm">${parseFloat(detalle.subtotal).toFixed(
    //                     2
    //                 )} Bs.</td>
    //             </tr>
    //         `);
    //     });
    // }
    editForm(id, title) {
        this.currentId = id;
        const reg = utilities.getByID(id, this.table, "id_propietario");
        this.modalEl.modal("show");
        utilities.reloadStyle();
        this.populateForm(reg);
    }

    populateForm(data) {
        this.form.find(":input").each(function () {
            const name = $(this).attr("name");
            if ($(this).prop("tagName") === "SELECT") {
                const choice = choiceInstances.find(
                    (el) => el._baseId === `choices--${name}`
                );
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
            error: (error) => this.handleSaveError(error),
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
