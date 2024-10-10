<link href="{{ asset('material-dashboard/assets/fileupload/filepond.css') }}" rel="stylesheet" />
<link href="{{ asset('material-dashboard/assets/fileupload/filepond-plugin-image-preview.css') }}" rel="stylesheet" />
<style>
    .filepond {
        /* width: 400px; */
        /* Ancho deseado */
        /* height: 100% !important; */
        /* Alto deseado */
        /* Estilo del borde */
        /* display: flex; */
        /* /* justify-content: center;
        align-items: center;
        flex-direction: column; */
        /* margin: 50px auto; */
        /* max-height: 200px; */
        /* Margen para centrar el contenedor */
    }

    .filepond--drop-label {
        /* height: 100% !important; */
    }
</style>
{{-- <style>
    .image-preview-container {
        max-width: 300px;
        margin: 0 auto;
    }

    .drop-area {
        border: 2px dashed #ccc;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        position: relative;
        cursor: pointer;
    }

    .drop-area:hover {
        background-color: #f0f0f0;
    }

    .image-preview {
        margin-top: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 10px;
    }
</style> --}}
<form id='form-main'>
    <div class="row mt-3 mb-2">
        <div class="col-12 col-sm-4 mt-3 mt-sm-0">
            <label for="image" class="form-label">Foto de perfil: </label>
            <input type="file" class="filepond" name="image" id="image"
                accept="image/png, image/jpeg, image/gif" />
            <small id='error-image' class="text-danger"></small>
            {{-- <div class="image-preview-container">
                <div id="drop-area" class="drop-area">
                    <p>Arrastra y suelta una imagen o <span class="label-action">examinar</span></p>
                    <input type="file" id="file-input" accept="image/*" style="display: none;">
                </div>
                <div id="preview" class="image-preview">
                    <img id="imageElement" src="" alt="Vista previa de la imagen" style="display: none;">
                </div>
            </div> --}}
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
        {{-- <div class="form-check mb-3" id="check-pass">
            <label class="custom-control-label" for="change">
                <p id="text-pass" class="text-warning text-sm mt-sm-3 mt-3"></p>
            </label>
            <input class="form-check-input mt-3" type="ckeckbox" name="change" value="1" id="change">
        </div> --}}

        <div class="col-12 col-sm-12 mt-3 mt-sm-3" id="rol-area">
            <label class="form-control ms-0 mb-0 p-0">Rol del usuario: </label>
            <div class="input-group input-group-outline">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="rol" value="administrador"
                        id="administrador">
                    <label class="custom-control-label" for="administrador">ADMINISTRADOR</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="rol" value="medico" id="medico">
                    <label class="custom-control-label" for="medico">MEDICO</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="rol" value="vendedor" id="vendedor">
                    <label class="custom-control-label" for="vendedor">VENDEDOR</label>
                </div>
                <small class="text-danger" id="error-rol" style='visibility: inherit'></small>
            </div>
        </div>
    </div>
    {{-- <script>
        $(document).ready(function() {
            $("#persona").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "/admin/getPersona", // Cambia esta URL a tu endpoint de API
                        dataType: "json",
                        data: {
                            string: request.term // Envía el término de búsqueda al servidor
                        },
                        success: function(data) {
                            // data debería ser un arreglo de objetos con propiedades 'value' y 'label'
                            response(data); // Procesa la respuesta del servidor
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Error en la petición AJAX: " + textStatus,
                                errorThrown);
                        }
                    });
                },
                minLength: 2, // Define el mínimo de caracteres antes de hacer la búsqueda
                select: function(event, ui) {
                    console.log(ui);
                    $("#id_persona").val(ui.item.id_persona);
                    $("#email").val(ui.item.email);
                    $("#password").val(ui.item.password);
                    $("#password_confirmation").val(ui.item.password);
                    console.log("Seleccionado: " + ui.item.value);
                    $("form#form-main :input").each(function() {
                        let e = $(this);
                        e.parent().addClass("is-filled")
                    });
                }
            });
        });
    </script> --}}
    <script src="{{ asset('material-dashboard/assets/fileupload/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/fileupload/filepond.js') }}"></script>
    <script>
        // Inicializar FilePond
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);

        // function loadImageFromURL(url) {
        //     fetch(url)
        //         .then(response => response.blob())
        //         .then(blob => {
        //             const file = new File([blob], 'marketing-online-que-es-caracteristicas-y-ejemplos.png', {
        //                 type: 'image/png'
        //             });
        //             pond.addFile(file);
        //         })
        //         .catch(error => console.error('Error al cargar la imagen:', error));
        // }

        // // URL de la imagen
        // const imageUrl = 'https://marketingblanco.com/imagenes/marketing-online-que-es-caracteristicas-y-ejemplos.png';

        // // Cargar imagen desde URL
        // loadImageFromURL(imageUrl);
    </script>
</form>
