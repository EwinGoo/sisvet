<div class="modal fade" id="modal-estado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-estado-title">Cambiar Estado de Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-estado">
                @csrf
                <input type="hidden" name="id" id="estado-cita-id">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="col-md-12">
                            <label for="estado" class="form-label">Nuevo Estado *</label>
                            <div class="input-group input-group-outline" id="select-validation-estado">
                                <select class="form-control choices" name="estado" id="estado" required>
                                    <option value="Confirmada">Confirmada</option>
                                    <option value="Completada">Completada</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                                <small class="text-danger error-message" error-name="estado"></small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3" id="motivo-cancelacion-container" style="display: none;">
                        <div class="row">
                            <div class="col-12 col-sm-12 mt-3">
                                <label for="motivo_cancelacion" class="form-label">Notas Adicionales</label>
                                <div class="input-group input-group-static az-input-group-outline ">
                                    <textarea id="motivo_cancelacion" name="motivo_cancelacion" class="form-control az-area p-3" rows="2"
                                        placeholder="Información adicional relevante"></textarea>
                                    <small id="error-estado">Error message</small>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-sm-12 mt-3">
                            <label for="motivo_cancelacion" class="form-label">Motivo de Cancelación *</label>
                            <div class="input-group input-group-outline mb-3">
                                <textarea id="motivo_cancelacion" name="motivo_cancelacion" class="form-control" rows="3"></textarea>
                                <small class="text-danger error-message" error-name="motivo_cancelacion"></small>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
