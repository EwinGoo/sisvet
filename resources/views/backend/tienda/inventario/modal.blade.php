{{-- <div class="modal-dialog modal-lg modal-dialog-centered" role="document"> --}}
<div class="modal fade" id="modal-main" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="modal-title">Nueva Persona</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1">
                @include('backend.tienda.inventario.form')
            </div>
            <div class="modal-footer">
                <button id="btn-cancel" type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal"><i
                        class="material-icons">close</i> Cancelar</button>
                <button id="btn-submit" type="button" class="btn bg-gradient-primary "><i
                        class="material-icons">done</i> Guardar</button>
            </div>
        </div>
    </div>
</div>

