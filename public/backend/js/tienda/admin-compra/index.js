import { ACTIONS, __dateFormat, __currencyFormat } from "./actions.js";
import { __bgFormat } from "../../components/actions.js";

class CompraManager {
    constructor() {
        this.form = $("#form-main");
        this.modalEl = $("#modal-main");
        this.modalTitle = $("#modal-title");
        this.btnNew = $("#btn-new");
        this.btnSubmit = $("#btn-submit");
        this.currentId = null; // Para manejar edición
        this.table = this.initDataTable();
        this.productoChoice = null; // Para almacenar la instancia de Choices
        this.proveedorChoice = null; // Para almacenar la instancia de Choices
        this.initEvents();
        this.initSelects();
        this.initializeUtilities();
    }

    initDataTable() {
        return $("#datatable").DataTable({
            language: languageTable,
            ajax: "/admin/compra",
            order: [[0, "desc"]], // Ordenar por fecha descendente
            columns: [
                { data: "id_compra" },
                { data: "fecha_compra", render: __dateFormat },
                { data: "producto" },
                { data: "cantidad_compra" },
                { data: "precio_total_compra", render: __currencyFormat },
                {
                    data: null,
                    targets: -1,
                    orderable: true,
                    render: (data, type, row) =>
                        __bgFormat(row.fecha_caducidad),
                },
                {
                    data: null,
                    targets: -1,
                    orderable: true,
                    render: (data, type, row) =>
                        row.proveedor ? row.proveedor : "N/A",
                },
                {
                    data: null,
                    render: (data) => ACTIONS("compra", data.id_compra),
                },
            ],
        });
    }

    initEvents() {
        // Nuevo registro
        this.btnNew.click(() => this.resetForm("Nueva Compra"));

        // Enviar formulario (crear/editar)
        // this.form.submit((e) => this.submitForm(e));
        this.btnSubmit.on("click", () => this.submitForm());

        // Editar registro (evento delegado por DataTable)
        this.table.on("click", ".edit", (e) => {
            const id = $(e.currentTarget).data("id");
            this.editForm(id);
        });

        // Eliminar registro
        this.table.on("click", ".delete", (e) => {
            const id = $(e.currentTarget).data("id");
            this.deleteCompra(id);
        });
    }

    initializeUtilities() {
        // utilities.initChoice();
        utilities.formValidateInit();
        utilities.ajaxSetup();
        // setTimeout(() => {
        //     this.setupChoiceListeners();
        // }, 300);
    }

    initSelects() {
        // Inicializar Choices.js para los selects
        const productoSelect = document.getElementById("id_producto");
        const proveedorSelect = document.getElementById("id_proveedor");

        if (productoSelect) {
            this.productoChoice = new Choices(productoSelect);
            this.proveedorChoice = new Choices(proveedorSelect);
            // this.loadProductos();
        }
    }

    resetForm(title) {
        this.modalTitle.text(title);
        this.form.trigger("reset");
        this.currentId = null;
        this.btnSubmit.prop("disabled", false);
        this.modalEl.modal("show");
    }

    editForm(id) {
        const self = this;
        $.get(`/admin/compra/${id}`, (data) => {
            this.modalTitle.text("Editar Compra #" + id);
            this.currentId = id;

            // Llenar formulario con los datos
            this.form.find(":input").each(function () {
                const name = $(this).attr("name");
                if ($(this).prop("tagName") === "SELECT") {
                    console.log(name);

                    name == "id_producto"
                        ? self.productoChoice.setChoiceByValue(
                              (data[name] || "").toString()
                          )
                        : self.proveedorChoice.setChoiceByValue(
                              (data[name] || "").toString()
                          );
                } else {
                    $(this).parent().addClass("is-filled");
                    $(this).val(data[name]);
                }
            });

            this.modalEl.modal("show");
        }).fail(() => console.error("Error al cargar la compra"));
    }

    submitForm() {
        const url = this.currentId
            ? `/admin/compra/${this.currentId}`
            : "/admin/compra";
        const method = this.currentId ? "PUT" : "POST";

        this.btnSubmit.prop("disabled", true);

        $.ajax({
            url: url,
            method: "POST",
            data: this.form.serialize() + `&_method=${method}`,
            success: (response) => {
                this.table.ajax.reload();
                this.modalEl.modal("hide");
                az.showSwal("success-message", null, response.message);
            },
            error: (error) => {
                if (error.responseJSON?.errors) {
                    // Mostrar errores de validación (requiere un helper)
                    this.btnSubmit.prop("disabled", false);
                    // this.showValidationErrors(error.responseJSON.errors);
                    utilities.formValidation(error.responseJSON.errors);
                } else {
                    // toastr.error("Error al procesar la solicitud");
                }
            },
            complete: () => this.btnSubmit.prop("disabled", false),
        });
    }

    deleteCompra(id) {
        az.showSwal("warning-message-delete", `/admin/compra/${id}`);
    }
    showValidationErrors(errors) {
        // Verifica si hay errores en la respuesta
        console.log(errors);

        if (errors) {
            // Itera sobre cada campo con error
            Object.keys(errors).forEach((fieldName) => {
                // Busca el input correspondiente en el formulario
                console.log(fieldName);

                const inputElement = $(`[name="${fieldName}"]`);

                if (inputElement) {
                    // Muestra el error (asumo que tienes una función showError)
                    // Toma solo el primer mensaje de error si es un array
                    const errorMessage = Array.isArray(errors[fieldName])
                        ? errors[fieldName][0]
                        : errors[fieldName];

                    showError(inputElement[0], errorMessage);
                } else {
                    console.warn(
                        `No se encontró el elemento con name="${fieldName}" en el formulario`
                    );
                }
            });
        } else {
            console.warn(
                'La respuesta de error no contiene la propiedad "errors"'
            );
        }
    }
}

$(document).ready(() => new CompraManager());
