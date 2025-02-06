class SalesManager {
    constructor() {
        // Elementos del formulario
        this.form = $("#ventaForm");
        this.formFields = {
            clientCode: document.querySelector('[name="ci"]'),
            clientId: document.querySelector('[name="id_cliente"]'),
            clientName: document.querySelector('[name="nombre"]'),
            buscador: document.querySelector("#buscador"),
            productCode: document.querySelector('[name="id_producto"]'),
            productName: document.querySelector('[name="nombre_producto"]'),
            price: document.querySelector('[name="precio"]'),
            quantity: document.querySelector('[name="cantidad"]'),
            url:'',
        };
        this.hiddenProductsContainer =
            document.getElementById("productos-hidden");

        // Botones
        this.buttons = {
            add: document.querySelector("#btn-add-product"),
            generate: document.querySelector("#btn-generate-sale"),
            cancel: document.querySelector("#btn-cancel-sale"),

            // this.table.on("click", ".edit", (e) => this.handleEdit(e));
        };

        // Tabla de detalles
        this.detailsTable = document.querySelector("#sales-details tbody");
        this.totalAmount = document.querySelector("#total-amount");

        // Estado de la venta
        this.saleDetails = [];
        this.total = 0;

        this.initializeComponents();
        this.initializeEventListeners();
    }

    initializeComponents() {
        // Inicializar Autocomplete para cliente
        $(this.formFields.clientCode).autocomplete({
            source: (request, response) => {
                $.ajax({
                    url: "/admin/cliente",
                    data: { query: request.term },
                    success: (data) => {
                        response(
                            data.data.map((item) => ({
                                label: `${item.ci} - ${item.nombre_completo}`,
                                value: item.ci,
                                item: item,
                            }))
                        );
                    },
                });
            },
            minLength: 2,
            select: (event, ui) => {
                event.preventDefault();
                this.formFields.clientCode.value = ui.item.value;
                this.formFields.clientId.value = ui.item.item.id_cliente;
                if (this.formFields.clientName) {
                    this.formFields.clientName.value =
                        ui.item.item.nombre_completo;
                }
            },
        });

        // Inicializar Autocomplete para producto
        $(this.formFields.buscador).autocomplete({
            source: (request, response) => {
                $.ajax({
                    url: "/admin/producto",
                    data: { query: request.term },
                    success: (data) => {
                        response(
                            data.data.map((item) => ({
                                label: `${item.id_producto} - ${item.nombre_producto}`,
                                value: item.id_producto,
                                item: item,
                            }))
                        );
                    },
                });
            },
            minLength: 2,
            select: (event, ui) => {
                console.log(ui.item);

                event.preventDefault();
                this.formFields.productCode.value = ui.item.value;
                this.formFields.productName.value =
                    ui.item.item.nombre_producto;
                this.formFields.price.value = ui.item.item.precio;
                this.formFields.quantity.value = 1;
                this.formFields.url = ui.item.item.ruta_archivo;
            },
        });
    }

    initializeEventListeners() {
        this.buttons.add.addEventListener("click", () => this.addProduct());
        this.buttons.generate.addEventListener("click", () =>
            this.generateSale()
        );
        this.buttons.cancel.addEventListener("click", () =>
            this.confirmCancel()
        );
        $(this.detailsTable).on("click", ".delete-product", (e) => {
            e.preventDefault();
            const index = $(e.currentTarget).data("index");
            this.removeProduct(index);
        });
    }

    addProduct() {
        // Validar campos
        if (!this.validateProductForm()) return;

        const product = {
            code: this.formFields.productCode.value,
            name: this.formFields.productName.value,
            price: parseFloat(this.formFields.price.value),
            quantity: parseInt(this.formFields.quantity.value),
            subtotal:
                parseFloat(this.formFields.price.value) *
                parseInt(this.formFields.quantity.value),
            url: this.formFields.url,
        };

        // Agregar a la lista
        this.saleDetails.push(product);

        // Actualizar tabla y total
        this.updateDetailsTable();
        this.updateTotal();
        this.updateHiddenInputs();

        // Resetear campos de producto
        this.resetProductFields();
    }

    validateProductForm() {
        const required = ["productCode", "productName"];
        let isValid = true;

        required.forEach((field) => {
            if (!this.formFields[field].value) {
                Swal.fire("Error", "Seleccione un producto.", "error");
                isValid = false;
            }
        });

        if (parseInt(this.formFields.quantity.value) <= 0) {
            Swal.fire("Error", "La cantidad debe ser mayor a 0", "error");
            isValid = false;
        }

        return isValid;
    }

    updateDetailsTable() {
        this.detailsTable.innerHTML = this.saleDetails
            .map(
                (item, index) => `
            <tr>
                <td class="align-middle text-center">
                    <span class="text-secondary text-sm">${item.code}</span>
                </td>
                <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                            <img src="${
                                item.url
                                    ? `/storage/${item.url}`
                                    : "/assets/images/no-image.png"
                            }"
                                class="avatar avatar-md me-3 img-preview" alt="table image" />
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">${item.name}</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-sm text-secondary mb-0">Bs. ${item.price.toFixed(
                        2
                    )}</p>
                </td>
                <td class="text-center">
                    <p class="text-sm text-secondary mb-0">${item.quantity}</p>
                </td>
                <td>
                    <p class="text-sm text-secondary mb-0">Bs. ${item.subtotal.toFixed(
                        2
                    )}</p>
                </td>
                <td class="align-middle text-center">
                    <a data-index="${index}" href="javascript:;"
                       class="text-danger delete-product" data-bs-toggle="tooltip"
                       data-bs-original-title="Quitar">
                        <i class="material-icons position-relative text-lg">delete</i>
                    </a>
                </td>
            </tr>
        `
            )
            .join("");
            utilities.tooltip();
    }

    updateHiddenInputs() {
        // Limpiar contenedor de productos hidden
        this.hiddenProductsContainer.innerHTML = "";

        // Crear inputs hidden para cada producto
        this.saleDetails.forEach((product, index) => {
            const productInputs = `
                <input type="hidden" name="productos[${index}][codigo]" value="${product.code}">
                <input type="hidden" name="productos[${index}][precio]" value="${product.price}">
                <input type="hidden" name="productos[${index}][cantidad]" value="${product.quantity}">
                <input type="hidden" name="productos[${index}][subtotal]" value="${product.subtotal}">
            `;
            this.hiddenProductsContainer.insertAdjacentHTML(
                "beforeend",
                productInputs
            );
        });

        // Actualizar total
        document.getElementById("total_venta").value = this.total;
    }

    updateTotal() {
        this.total = this.saleDetails.reduce(
            (sum, item) => sum + item.subtotal,
            0
        );
        this.totalAmount.textContent = `Bs. ${this.total.toFixed(2)}`;
    }

    removeProduct(index) {
        const deleteButton = this.detailsTable.querySelectorAll('.delete-product')[index];
        $(deleteButton).tooltip('dispose');

        this.saleDetails.splice(index, 1);
        this.updateDetailsTable();
        this.updateTotal();
        this.updateHiddenInputs();
        // utilities.tooltip('dispose');
    }

    resetProductFields() {
        this.formFields.productCode.value = "";
        this.formFields.productName.value = "";
        this.formFields.price.value = "";
        this.formFields.quantity.value = "";
        this.formFields.buscador.value = "";
    }

    confirmCancel() {
        if (this.saleDetails.length === 0) {
            this.resetAll();
            return;
        }

        Swal.fire({
            title: "¿Está seguro?",
            text: "Se perderán todos los productos agregados",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, cancelar",
            cancelButtonText: "No, mantener",
        }).then((result) => {
            if (result.isConfirmed) {
                this.resetAll();
                Swal.fire("Cancelado", "La venta ha sido cancelada", "success");
            }
        });
    }

    resetAll() {
        this.formFields.clientCode.value = "";
        if (this.formFields.clientName) {
            this.formFields.clientName.value = "";
        }
        this.resetProductFields();
        this.saleDetails = [];
        this.updateDetailsTable();
        this.updateTotal();
    }

    generateSale() {
        if (this.saleDetails.length === 0) {
            Swal.fire("Error", "Debe agregar al menos un producto", "error");
            return;
        }

        // const saleData = {
        //     client_code: this.formFields.clientCode.value,
        //     client_name: this.formFields.clientName?.value,
        //     total: this.total,
        //     details: this.saleDetails
        // };
        console.log(this.form);

        const saleData = this.form.serialize();

        // Enviar datos via AJAX
        $.ajax({
            url: "/admin/venta",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: saleData,
            // contentType: 'application/json',
            success: (response) => {
                Swal.fire("Éxito", "Venta generada correctamente", "success");
                this.resetAll();
            },
            error: (error) => {
                Swal.fire("Error", "No se pudo generar la venta", "error");
                console.error("Error generating sale:", error);
            },
        });
    }
}

// Inicializar el gestor de ventas
const salesManager = new SalesManager();
