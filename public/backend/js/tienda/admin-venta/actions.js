export function ACTIONS(name = "", id = null) {
    return /*html */`
    <td class="text-sm">
        <!--<a href="javascript:;" data-bs-toggle="tooltip"
            data-bs-original-title="Vista previa de ${name}">
            <i class="material-icons text-info position-relative text-lg">visibility</i>
        </a>-->
        <a data-id="${id}" href="javascript:;" class="ms-3 details" data-bs-toggle="tooltip"
            data-bs-original-title="Detalle ${name}">
            <i class="material-icons text-info position-relative text-lg">visibility</i>
        </a>
        <a data-id="${id}" href="javascript:;" class="ms-3 delete" data-bs-toggle="tooltip"
            data-bs-original-title="Eliminar ${name}">
            <i class="material-icons text-danger position-relative text-lg">delete</i>
        </a>
        <a href="/admin/venta/${id}/comprobante" class="ms-3 btn btn-sm btn-success" data-bs-toggle="tooltip"
            data-bs-original-title="Generar Comprobante" style="padding: 2px 8px;">
            Comprobante
        </a>
    </td>
    `;
}

export function BTN_STATE() {}

export function updateModalDetails(modalBody, venta, detalles) {
    // Restaurar el contenido original del modal (sin el spinner)
    modalBody.html(/*html */`
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Información de la Venta</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-sm mb-1"><strong>ID Venta:</strong> <span id="venta-id">${venta.id_venta}</span></p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-sm mb-1"><strong>Fecha:</strong> <span id="venta-fecha">${venta.fecha}</span></p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-sm mb-1"><strong>Hora:</strong> <span id="venta-hora">${venta.hora}</span></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <p class="text-sm mb-1"><strong>Vendedor:</strong> <span id="venta-vendedor">${venta.vendedor}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-sm mb-1"><strong>Cliente:</strong> <span id="venta-cliente">${venta.cliente || 'Sin cliente registrado'}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Productos Vendidos</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Producto</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Código</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cantidad</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Precio Unitario</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="detalle-productos">
                                    ${detalles.map(detalle => `
                                        <tr>
                                            <td class="text-sm">${detalle.nombre_producto}</td>
                                            <td class="text-sm">${detalle.id_producto}</td>
                                            <td class="text-sm">${detalle.cantidad}</td>
                                            <td class="text-sm">${parseFloat(detalle.precio_unitario).toFixed(2)} Bs.</td>
                                            <td class="text-sm">${parseFloat(detalle.subtotal).toFixed(2)} Bs.</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                        <td class="text-sm"><strong id="venta-total">${parseFloat(venta.total_venta).toFixed(2)} Bs.</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
}
