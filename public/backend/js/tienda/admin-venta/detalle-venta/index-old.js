// import Swal from '../lib/sweetalert2.min.js';
// import '/assets/lib/css/tom-select.css';

class SalesManager {
    constructor() {
        // Elementos del formulario
        this.form = {
            clientCode: document.querySelector('[name="id_cliente"]'),
            clientName: document.querySelector('[name="nombre"]'),
            productCode: document.querySelector('[name="id_producto"]'),
            productName: document.querySelector('[name="product_name"]'),
            price: document.querySelector('[name="price"]'),
            quantity: document.querySelector('[name="quantity"]')
        };

        // Botones
        this.buttons = {
            add: document.querySelector('#btn-add-product'),
            generate: document.querySelector('#btn-generate-sale'),
            cancel: document.querySelector('#btn-cancel-sale')
        };

        // Tabla de detalles
        this.detailsTable = document.querySelector('#sales-details tbody');
        this.totalAmount = document.querySelector('#total-amount');

        // Estado de la venta
        this.saleDetails = [];
        this.total = 0;

        this.initializeComponents();
        this.initializeEventListeners();
    }

    initializeComponents() {
        // Inicializar TomSelect para cliente
        this.clientSelect = new TomSelect(this.form.clientCode, {
            valueField: 'id_cliente',
            labelField: 'nombre',
            searchField: ['id_cliente', 'nombre'],
            maxItems: 1, 
            load: (query, callback) => this.loadClients(query, callback),
            onChange: (value) => this.handleClientSelection(value)
        });

        // Inicializar TomSelect para producto
        this.productSelect = new TomSelect(this.form.productCode, {
            valueField: 'code',
            labelField: 'name',
            searchField: ['code', 'name'],
            load: (query, callback) => this.loadProducts(query, callback),
            onChange: (value) => this.handleProductSelection(value)
        });
    }

    async loadClients(query, callback) {
        try {
            const response = await fetch(`/admin/cliente?query=${query}`);
            const data = await response.json();
            callback(data);
        } catch (error) {
            console.error('Error loading clients:', error);
            callback();
        }
    }

    async loadProducts(query, callback) {
        try {
            const response = await fetch(`/api/products/search?q=${query}`);
            const data = await response.json();
            callback(data);
        } catch (error) {
            console.error('Error loading products:', error);
            callback();
        }
    }

    handleClientSelection(v) {
        if (!v) return;
        // console.log(value);
        this.form.clientCode.value = v;
        // this.form.clientName.value = ;
        
        // fetch(`/api/clients/${value}`)
        //     .then(response => response.json())
        //     .then(client => {
        //         this.form.clientName.value = client.name;
        //     })
        //     .catch(error => console.error('Error fetching client details:', error));
    }

    handleProductSelection(value) {
        if (!value) return;
        
        fetch(`/api/products/${value}`)
            .then(response => response.json())
            .then(product => {
                this.form.productName.value = product.name;
                this.form.price.value = product.price;
                this.form.quantity.value = "1";
                this.form.quantity.max = product.stock;
            })
            .catch(error => console.error('Error fetching product details:', error));
    }

    initializeEventListeners() {
        this.buttons.add.addEventListener('click', () => this.addProduct());
        this.buttons.generate.addEventListener('click', () => this.generateSale());
        this.buttons.cancel.addEventListener('click', () => this.confirmCancel());
    }

    addProduct() {
        // Validar campos
        if (!this.validateProductForm()) return;

        const product = {
            code: this.form.productCode.value,
            name: this.form.productName.value,
            price: parseFloat(this.form.price.value),
            quantity: parseInt(this.form.quantity.value),
            subtotal: parseFloat(this.form.price.value) * parseInt(this.form.quantity.value)
        };

        // Agregar a la lista
        this.saleDetails.push(product);
        
        // Actualizar tabla y total
        this.updateDetailsTable();
        this.updateTotal();
        
        // Resetear campos de producto
        this.resetProductFields();
    }

    validateProductForm() {
        const required = ['productCode', 'productName', 'price', 'quantity'];
        let isValid = true;

        required.forEach(field => {
            if (!this.form[field].value) {
                Swal.fire('Error', 'Todos los campos son requeridos', 'error');
                isValid = false;
            }
        });

        if (parseInt(this.form.quantity.value) <= 0) {
            Swal.fire('Error', 'La cantidad debe ser mayor a 0', 'error');
            isValid = false;
        }

        return isValid;
    }

    updateDetailsTable() {
        this.detailsTable.innerHTML = this.saleDetails.map((item, index) => `
            <tr>
                <td class="align-middle text-center">
                    <span class="text-secondary text-sm">${item.code}</span>
                </td>
                <td>
                    <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">${item.name}</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-sm text-secondary mb-0">Bs. ${item.price.toFixed(2)}</p>
                </td>
                <td class="text-center">
                    <p class="text-sm text-secondary mb-0">${item.quantity}</p>
                </td>
                <td>
                    <p class="text-sm text-secondary mb-0">Bs. ${item.subtotal.toFixed(2)}</p>
                </td>
                <td class="align-middle text-center">
                    <a href="javascript:;" onclick="salesManager.removeProduct(${index})" 
                       class="text-danger" data-bs-toggle="tooltip" 
                       data-bs-original-title="Quitar">
                        <i class="material-icons position-relative text-lg">delete</i>
                    </a>
                </td>
            </tr>
        `).join('');
    }

    updateTotal() {
        this.total = this.saleDetails.reduce((sum, item) => sum + item.subtotal, 0);
        this.totalAmount.textContent = `Bs. ${this.total.toFixed(2)}`;
    }

    removeProduct(index) {
        this.saleDetails.splice(index, 1);
        this.updateDetailsTable();
        this.updateTotal();
    }

    resetProductFields() {
        this.productSelect.clear();
        this.form.productName.value = '';
        this.form.price.value = '';
        this.form.quantity.value = '';
    }

    confirmCancel() {
        if (this.saleDetails.length === 0) {
            this.resetAll();
            return;
        }

        Swal.fire({
            title: '¿Está seguro?',
            text: "Se perderán todos los productos agregados",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, mantener'
        }).then((result) => {
            if (result.isConfirmed) {
                this.resetAll();
                Swal.fire(
                    'Cancelado',
                    'La venta ha sido cancelada',
                    'success'
                );
            }
        });
    }

    resetAll() {
        this.clientSelect.clear();
        this.form.clientName.value = '';
        this.resetProductFields();
        this.saleDetails = [];
        this.updateDetailsTable();
        this.updateTotal();
    }

    generateSale() {
        if (this.saleDetails.length === 0) {
            Swal.fire('Error', 'Debe agregar al menos un producto', 'error');
            return;
        }

        const saleData = {
            client_code: this.form.clientCode.value,
            client_name: this.form.clientName.value,
            total: this.total,
            details: this.saleDetails
        };

        // Enviar datos via AJAX
        $.ajax({
            url: '/api/sales',
            method: 'POST',
            data: JSON.stringify(saleData),
            contentType: 'application/json',
            success: (response) => {
                Swal.fire('Éxito', 'Venta generada correctamente', 'success');
                this.resetAll();
            },
            error: (error) => {
                Swal.fire('Error', 'No se pudo generar la venta', 'error');
                console.error('Error generating sale:', error);
            }
        });
    }
}

// Inicializar el gestor de ventas
const salesManager = new SalesManager();