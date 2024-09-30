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
        id;
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
            modalTitle.text("nuevo usuario");
            btnSubmit.removeAttr("data-id", id);
            utilities.resetForm(form);
            btnSubmit.prop("disabled", false);
            $("#admin").val("admin");
            $("#user").val("user");
            $("#text-pass").text("");
            $("#change-field").css("display", "none");
            this.id = null;
            $("#password").prop("disabled", false);
            $("#password_confirmation").prop("disabled", false);
        },
        edit: function (id) {
            modalTitle.text("editar usuario");
            utilities.resetForm(form);
            this.id = id;
            btnSubmit.prop("disabled", false);
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
                    console.log(row.estado);
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
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
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
                // console.log(name, "entro", reg[name]);
                // let radio = ;
                // let choice = choiceInstances.filter(
                //     (elemento) => elemento._baseId === "choices--" + name
                // );
                // choice[0].setChoiceByValue(reg[name]);
                $(`#${reg[name].toLowerCase()}`).prop("checked", true);
            } else {
                $(this).parent().addClass("is-filled");
                $(this).val(reg[name]);
            }
        });
        $("#change-field").css("display", "block");
        $("#admin").val("admin");
        $("#user").val("user");
        $("#change").val("1");
        // $("#text-pass").text("¿Desea cambiar la contraseña?");
        // $("#email").val(reg.email);
        // $("#persona").val(reg.nombre_completo);
        // $("#id_persona").val(reg.id_persona);
        $("#password").prop("disabled", true);
        $("#password_confirmation").prop("disabled", true);
        // $("#check-pass").removeClass("d-none");

        utilities.reloadStyle();
        // $("form#form-main :input").each(function () {
        //     $(this).parent().addClass("is-filled");
        // });
    }
    function saveRegister(url, method) {
        // utilities.ajaxSetup();/
        // $("#email").prop("disabled", false);
        $.ajax({
            type: method,
            url,
            data: form.serialize(),
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
                // $("#error-rol").text(errors.rol);
            },
        });
    }
    function changePass() {}
});
