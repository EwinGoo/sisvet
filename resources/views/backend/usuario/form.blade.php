<form id='form-main' enctype="multipart/form-data">
    <div class="row mt-3 mb-2">
        <div class="col-12 col-sm-4 mt-3 mt-sm-0">
            <label for="image" class="form-label">Foto de perfil: </label>
            <div class="image-uploader h-0 m-0">
                <div class="upload-area" id="uploadArea" style="height: 100%">
                    <div class="upload-placeholder" id="placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div class="upload-text">
                            Arrastra una imagen aquí<br />o haz clic para seleccionar
                        </div>
                    </div>
                    <input type="file" id="fileInput" name="image" accept="image/*" style="display: none" />
                    <small id='error-image' class="text-danger"></small>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 mt-3 mt-sm-0">
            <div class="row mb-2">
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                    <div class="input-group input-group-outline">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input id="nombre" name="nombre" class="form-control" type="text" />
                        <small>Error message</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                    <div class="input-group input-group-outline">
                        <label for="paterno" class="form-label">Paterno</label>
                        <input id="paterno" name="paterno" class="form-control" type="text" />
                        <small>Error message</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-3">
                    <div class="input-group input-group-outline">
                        <label for="materno" class="form-label">Materno</label>
                        <input id="materno" name="materno" class="form-control" type="text" />
                        <small>Error message</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-3">
                    <div class="input-group input-group-outline">
                        <label for="celular" class="form-label">Celular</label>
                        <input id="celular" name="celular" class="form-control" type="text" minlength="8"
                            maxlength="8" />
                        <small>Error message</small>
                    </div>
                </div>
                <div class="col-12 col-sm-12 mt-3 mt-sm-3">
                    <div class="input-group input-group-outline">
                        <label for="email" class="form-label">Correo</label>
                        <input id="email" name="email" class="form-control" type="email" />
                        <small>Error message</small>
                    </div>
                </div>
                <div class="col-12 col-sm-12 mt-3 mt-sm-3">
                    <div class="input-group input-group-outline">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input id="usuario" name="usuario" class="form-control" type="text" />
                        <small>Error message</small>
                    </div>
                </div>
                <div class="col-12 col-sm-12 mt-3 mt-sm-3" id="change-field">
                    <div class="form-check p-0">
                        <input id="change" name="change" class="form-check-input" type="checkbox" value="1"
                            checked="">
                        <label class="custom-control-label" for="change">¿Desea cambiar la contraseña?</label>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-3">
                    <div class="input-group input-group-outline">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" name="password" class="form-control" type="text" />
                        <small>Error message</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-3">
                    <div class="input-group input-group-outline">
                        <label for="password_confirmation" class="form-label">Confirme Contraseña</label>
                        <input id="password_confirmation" name="password_confirmation" class="form-control"
                            type="text" />
                        <small>Error message</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-2">

        <div class="col-12 col-sm-12 mt-3 mt-sm-3" id="rol-area">
            <label class="form-control ms-0 mb-0 p-0">Rol del usuario: </label>
            <div class="input-group input-group-outline">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="rol" value="1"
                        id="administrador">
                    <label class="custom-control-label" for="administrador">ADMINISTRADOR</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="rol" value="2" id="medico">
                    <label class="custom-control-label" for="medico">MEDICO</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="rol" value="3" id="vendedor">
                    <label class="custom-control-label" for="vendedor">VENDEDOR</label>
                </div>
                <small class="text-danger" id="error-rol" style='visibility: inherit'></small>
            </div>
        </div>
    </div>
</form>
