import { ACTIONS } from "./actions.js";

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
    btnState = {
        id: null,
        add: function () {
            modalTitle.text("nueva mascota");
            btnSubmit.removeAttr("data-id", id);
            utilities.resetForm(form);
            btnSubmit.prop("disabled", false);
            this.id = null;
        },
        edit: function (id) {
            modalTitle.text("editar mascota");
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
            url: "/admin/mascota",
        },
        columns: [
            { data: "id_mascota" },
            { data: "nombre_mascota" },
            { data: "nombre_completo" },
            // { data: "celular" },
            {
                data: null,
                targets: -1,
                orderable: false,
                render: function (data, type, row) {
                    // console.log(row);
                    return ACTIONS("mascota", row.id_mascota);
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

    table.on("click", ".edit", function () {
        let id = $(this).data("id");
        btnState.edit(id);
        edit(id, table);
    });
    table.on("click", ".delete", function () {
        let id = $(this).data("id");
        az.showSwal("warning-message-delete", `/admin/mascota/${id}`);
    });
    btnNew.on("click", function (e) {
        btnState.add();
    });
    btnSubmit.on("click", function () {
        let id = btnState.id;
        btnSubmit.prop("disabled", true);
        if (!id) {
            saveRegister("/admin/mascota", "POST");
        } else {
            saveRegister(`/admin/mascota/${id}`, "PUT");
        }
    });
    function edit(id, table) {
        let reg = utilities.getByID(id, table, "id_mascota");
        console.log(reg);
        
        modalEl.modal("show");
        utilities.reloadStyle();
        $("form#form-main :input").each(function () {
            let name = $(this).attr("name");
            if ($(this).prop("tagName") === "SELECT") {
                // let choice = choiceInstances.filter(
                //     (elemento) => elemento._baseId === "choices--" + name
                // );
                // choice[0].setChoiceByValue(reg[name]);
                document.addEventListener('DOMContentLoaded', function () {
                const element = document.getElementById('id_propietario');

                if (element && element.choices) {
                    element.choices.setChoiceByValue('2');
                } else {
                    console.error('Choices.js no está inicializado correctamente o el elemento no existe.');
                }
                // console.log(element.choice);
                const choicesInstance =element.choice;
                
                // const choices = new Choices(element);
                // Seleccionar el valor '2' del select
                // console.log(reg[name]);
                
                choicesInstance.setChoiceByValue(`${reg[name]}`);
            });
            } else {
                $(this).parent().addClass("is-filled");
                $(this).val(reg[name]); 
            }
        });
    }
    function saveRegister(url, method) {
        // utilities.ajaxSetup();/
        $.ajax({
            type: method,
            url,
            data: form.serialize(),
            success: (d) => {
                modalEl.modal("hide");
                $("#datatable").DataTable().ajax.reload();
                az.showSwal("success-message", null, d.message);
            },
            error: function (data) {
                btnSubmit.prop("disabled", false);
                let errors = data.responseJSON.errors;
                utilities.formValidation(errors);
            },
        });
    }
});
