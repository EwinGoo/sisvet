{{-- resources/views/backend/consultorio/cita/form.blade.php --}}
<form id='form-main' autocomplete="off">
    <div class="row">
        {{-- Campo Propietario --}}
        <div class="col-md-12">
            <div class="input-group input-group-static" id="select-validation-id_propietario">
                <label for="id_propietario" class="ms-0">Propietario *</label>
                <select class="form-control choices" name="id_propietario" id="id_propietario" required>
                    <option value="">[SELECCIONE]</option>
                    @foreach ($data['propietarios'] as $item)
                        <option value="{{ $item->id_propietario }}">{{$item->ci . ' - ' . $item->nombre_completo   }}
                        </option>
                    @endforeach
                </select>
                <small class="select-error" error-name="id_propietario">Error message</small>
            </div>
        </div>

        {{-- Campo Mascota (se carga dinámicamente) --}}
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-outline" id="select-validation-id_mascota">
                <label for="id_mascota" class="ms-0">Mascota *</label>
                <select class="form-control choices" name="id_mascota" id="id_mascota" required>
                    <option value="">[SELECCIONE PROPIETARIO PRIMERO]</option>
                </select>
                <small class="select-error" error-name="id_mascota">Error message</small>
            </div>
        </div>

        {{-- Tipo de Consulta --}}
        <div class="col-12 col-sm-12 mt-3">
            <div class="input-group input-group-static" id="select-validation-tipo_consulta">
                <label for="tipo_consulta" class="ms-0">Tipo de Consulta *</label>
                <select class="form-control choices" name="tipo_consulta" id="tipo_consulta" required data-placeholder="This is a placeholder">
                    <option value="">[SELECCIONE]</option>
                    <option value="Consulta general">Consulta general</option>
                    <option value="Vacunación">Vacunación</option>
                    <option value="Urgencia">Urgencia</option>
                    <option value="Cirugía">Cirugía</option>
                    <option value="Estética">Estética</option>
                    <option value="Otro">Otro</option>
                </select>
                <small class="select-error" error-name="tipo_consulta">Error message</small>
            </div>
        </div>

        {{-- Fecha y Hora --}}
        <div class="col-12 col-sm-6 mt-3">
            <div class="input-group input-group-outline">
                <label for="fecha_hora" class="form-label">Fecha y Hora *</label>
                <input id="fecha_hora" name="fecha_hora" class="form-control" type="datetime-local" />
                <small>Error message</small>
            </div>
        </div>

        {{-- Duración --}}
        <div class="col-md-6 col-sm-12 mt-3">
            <div class="input-group input-group-outline">
                <label for="duracion" class="form-label">Duración (minutos) *</label>
                <input type="number" class="form-control" name="duracion" id="duracion" min="15" max="120">
                <small>Error message</small>
            </div>
        </div>

        {{-- Motivo --}}
        <div class="col-12 col-sm-12 mt-3">
            <label for="motivo" class="form-label">Motivo de la Consulta *</label>
            <div class="input-group input-group-static az-input-group-outline ">
                <textarea id="motivo" name="motivo" class="form-control az-area p-3" rows="2" placeholder="Describa el motivo de la consulta"></textarea>
                <small>Error message</small>
            </div>
        </div>

        {{-- Notas Adicionales --}}
        <div class="col-12 col-sm-12 mt-3">
            <label for="notas" class="form-label">Notas Adicionales</label>
            <div class="input-group input-group-static az-input-group-outline ">
                <textarea id="notas" name="notas" class="form-control az-area p-3" rows="2" placeholder="Información adicional relevante"></textarea>
                <small>Error message</small>
            </div>
        </div>
    </div>
</form>
