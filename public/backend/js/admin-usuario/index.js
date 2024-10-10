import { _ACTIONS, _ESTADO } from "./actions.js";

$(document).ready(function () {
    // variables
    var form,
        modalEl,
        modalTitle,
        btnNew,
        btnCancel,
        btnSubmit,
        btnTextSubmit,
        btnState,
        table,
        id,
        imgState,
        isFirst;
    form = $("#form-main");
    modalEl = $("#modal-main");
    modalTitle = $("#modal-title");
    btnNew = $("#btn-new");
    btnSubmit = $("#btn-submit");
    btnTextSubmit, btnState, table, id;
    // dataTable = $("#datatable");
    // modalEl.modal("show");

    btnState = {
        id: null,
        add: function () {
            // imgState = true;
            // isFirst = true;
            modalTitle.text("nuevo usuario");
            btnSubmit.removeAttr("data-id", id);
            utilities.resetForm(form);
            btnSubmit.prop("disabled", false);
            $("#administrador").val("administrador");
            $("#vendedor").val("vendedor");
            $("#medico").val("medico");
            $("#text-pass").text("");
            $("#change-field").css("display", "none");
            this.id = null;
            $("#password").prop("disabled", false);
            $("#password_confirmation").prop("disabled", false);
            pond.removeFiles();
        },
        edit: function (id) {
            imgState = false;
            // isFirst = true;
            modalTitle.text("editar usuario");
            utilities.resetForm(form);
            this.id = id;
            btnSubmit.prop("disabled", false);
            pond.removeFiles();
        },
    };

    table = $("#datatable").DataTable({
        order: [[0, "desc"]],
        responsive: true,
        language: {
            searchPlaceholder: "Buscar...",
        },
        lengthMenu: [
            [5, 25, 50, -1],
            [10, 25, 50, "Todos"],
        ],
        pagingType: "full_numbers",
        ajax: {
            url: "/admin/usuario",
        },
        columns: [
            { data: "id_usuario" },
            // {
            //     data: null,
            //     targets: 2,
            //     render: function (data, type, row) {
            //         // Concatenar nombre_completo con paterno y materno
            //         return row.nombre + " " + row.paterno + " " + row.materno;
            //     }
            // },
            {
                data: null,
                targets: 1,
                orderable: false,
                render: function (data, type, row) {
                    // console.log(row);
                    let nombre_completo =
                        row.nombre +
                        " " +
                        row.paterno +
                        " " +
                        (row.materno ? row.materno : "");
                    return nombre_completo;
                },
            },
            { data: "usuario" },
            { data: "rol" },
            {
                data: null,
                targets: -1,
                orderable: false,
                render: function (data, type, row) {
                    return _ESTADO(row.id_usuario, row.estado);
                },
            },
            {
                data: null,
                targets: -1,
                orderable: false,
                render: function (data, type, row) {
                    // console.log(row);
                    return _ACTIONS("usuario", row.id_usuario);
                },
            },
        ],
        drawCallback: function () {
            utilities.tooltip();
            utilities.loaderTool();
        },
    });
    utilities.initChoice();
    utilities.formValidateInit();
    utilities.ajaxSetup();
    // choiceInstances[1].disable();
    table.on("click", ".edit", function () {
        let id = $(this).data("id");
        btnState.edit(id);
        edit(id, table);
    });
    table.on("click", ".delete", function () {
        let id = $(this).data("id");
        az.showSwal("warning-message-delete", `/admin/usuario/${id}`);
    });
    table.on("click", ".state", function () {
        let userId = $(this).data("id");
        let state = $(this).data("state");
        let message = !state
            ? "¿Quieres activar la cuenta?"
            : "¿Quieres desactivar la cuenta?";

        // Mostrar alerta SweetAlert
        Swal.fire({
            title: "Confirmación",
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí puedes manejar la activación/desactivación
                // Por ejemplo, hacer una llamada AJAX para cambiar el estado
                $.ajax({
                    url: "/admin/change-state-user", // Cambia la URL por la ruta adecuada
                    method: "POST",
                    data: {
                        id: userId,
                    },
                    success: function (response) {
                        // Mensaje de éxito
                        Swal.fire("¡Hecho!", response.message, "success");
                        $("#datatable").DataTable().ajax.reload();
                    },
                    error: function () {
                        // Mensaje de error
                        Swal.fire(
                            "Error",
                            "Ocurrió un error al intentar cambiar el estado.",
                            "error"
                        );
                    },
                });
            }
        });
    });
    btnNew.on("click", function (e) {
        btnState.add();
    });
    btnSubmit.on("click", function () {
        let id = btnState.id;
        btnSubmit.prop("disabled", true);
        if (!id) {
            saveRegister("/admin/usuario", "POST");
        } else {
            saveRegister(`/admin/usuario/${id}`, "PUT");
        }
    });
    $("#change").click(function () {
        $("#password").prop("disabled", false);
        $("#password_confirmation").prop("disabled", false);
    });

    function edit(id, table) {
        let reg = utilities.getByID(id, table, "id_usuario");
        console.log(reg);
        modalEl.modal("show");
        $("form#form-main :input").each(function () {
            let name = $(this).attr("name");
            if ($(this).is(":radio")) {
                console.log(reg[name]);

                $(`#${reg[name].toLowerCase()}`).prop("checked", true);
            } else {
                $(this).parent().addClass("is-filled");
                $(this).val(reg[name]);
            }
        });
        $("#change-field").css("display", "block");
        $("#administrador").val("administrador");
        $("#medico").val("medico");
        $("#vendedor").val("vendedor");
        $("#change").val("1");
        // $("#text-pass").text("¿Desea cambiar la contraseña?");
        // $("#email").val(reg.email);
        // $("#persona").val(reg.nombre_completo);
        // $("#id_persona").val(reg.id_persona);
        $("#password").prop("disabled", true);
        $("#password_confirmation").prop("disabled", true);
        // $("#check-pass").removeClass("d-none");
        getImage(reg.id_usuario)
            .then((image) => {
                pond.addFiles([
                    {
                        source: image,
                        options: {
                            type: "local",
                        },
                    },
                ]);
            })
            .catch((error) => {
                console.error(error);
            });
        utilities.reloadStyle();
        // isFirst = false;
    }
    function saveRegister(url, method) {
        const files = pond.getFiles();
        let formData = new FormData($("#form-main")[0]);

        if (files.length == 1 && imgState) {
            formData.append("image", files[0].file); // '
            console.log(imgState, formData);
            // return;
        } else {
            formData.delete("image");
        }
        formData.append("_method", method);
        $.ajax({
            type: "POST",
            url,
            data: formData,
            contentType: false, // Para que jQuery no establezca el tipo de contenido
            processData: false,
            success: (d) => {
                // console.log(d);
                modalEl.modal("hide");
                $("#datatable").DataTable().ajax.reload();
                az.showSwal("success-message", null, d.message);
            },
            error: function (data) {
                btnSubmit.prop("disabled", false);
                let errors = data.responseJSON.errors;
                console.log(errors);
                utilities.formValidation(errors);
                // console.log(errors.rol);
                // $("#email").prop("disabled", true);
                $("#error-rol").text(errors.rol);
            },
        });
    }
    $("#image").on("click", function () {
        $("#error-image").text("");
        imgState = true;
    });
    $("#rol-area").on("click", function () {
        $("#error-rol").text("");
    });
    async function getImage(id) {
        try {
            const response = await $.ajax({
                type: "GET",
                url: "/admin/usuario/" + id + "/image",
            });
            return response.image; // Devuelve la imagen
        } catch (data) {
            // console.log(data.responseJSON.message); // Manejo de errores
            throw new Error(data.responseJSON.message); // Lanza el error
        }
    }
    // // Obtén los elementos del DOM
    // const dropArea = document.getElementById("drop-area");
    // const fileInput = document.getElementById("file-input");
    // const imageElement = document.getElementById("imageElement");

    // // Evitar el comportamiento por defecto
    // dropArea.addEventListener("dragover", (event) => {
    //     event.preventDefault();
    // });

    // dropArea.addEventListener("drop", (event) => {
    //     event.preventDefault();
    //     const files = event.dataTransfer.files;
    //     handleFiles(files);
    // });

    // dropArea.addEventListener("click", () => {
    //     fileInput.click(); // Abre el selector de archivos al hacer clic en el área
    // });

    // // Cuando se selecciona un archivo
    // fileInput.addEventListener("change", (event) => {
    //     const files = event.target.files;
    //     handleFiles(files);
    // });

    // // Función para manejar los archivos
    // function handleFiles(files) {
    //     if (files.length > 0) {
    //         const file = files[0];
    //         if (file.type.startsWith("image/")) {
    //             const reader = new FileReader();
    //             reader.onload = function (e) {
    //                 imageElement.src = e.target.result;
    //                 imageElement.style.display = "block"; // Muestra la imagen
    //             };
    //             reader.readAsDataURL(file); // Convierte la imagen a base64
    //         } else {
    //             alert("Por favor, selecciona solo imágenes.");
    //         }
    //     }
    // }
});
