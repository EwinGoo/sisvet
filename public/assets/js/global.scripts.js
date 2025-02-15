var utilities;
const choiceInstances = {};
var loader = $(".az-spinner");
var table = $(".table-responsive");
// $(document).ready(function () {
utilities = {
    tooltip: function ($dispose = "") {
        // $dispose
        //     ? $('[data-bs-toggle="tooltip"]').tooltip('dispose')
        //     : $('[data-bs-toggle="tooltip"]').tooltip();
        $('[data-bs-toggle="tooltip"]').tooltip();
    },
    styleTable: function () {
        const rows = document.querySelectorAll("#datatable tbody tr");
        rows.forEach((row) => {
            row.classList.add("text-sm"); // Agrega clases de estilo a cada fila
        });
    },
    formValidateInit: function () {
        $("form#form-main :input").change(function () {
            var e = this; // "this" hace referencia al elemento de entrada que ha cambiado
            e.parentElement.classList.remove("is-invalid", "mb-3");
            var smallElement = e.parentElement.querySelector("small");
            if ($(this).prop("tagName") === "SELECT")
                $(`#select-validation-${$(e).attr("name")}`).removeClass(
                    "is-invalid mb-3"
                );
            if (smallElement) {
                smallElement.innerText = "";
            }
        });
    },
    reloadStyle: function () {
        $("form#form-main :input").change(function () {
            var e = this; // "this" hace referencia al elemento de entrada que ha cambiado
            var smallElement = e.parentElement.querySelector("small");
            if (e.parentElement) {
                $(e.parentElement).addClass("is-filled");
            }
            if ($(this).prop("tagName") === "SELECT")
                $(`#select-validation-${$(e).attr("name")}`).removeClass(
                    "is-invalid mb-3"
                );
            if (smallElement) {
                smallElement.innerText = "";
            }
        });
    },
    formValidation: function (errors) {
        $("form#form-main :input").each(function () {
            let name = $(this).attr("name");
            let value = $(this).val();

            if ($(this).prop("tagName") === "SELECT") {
                if (errors.hasOwnProperty(name)) {
                    showError($(`[error-name="${name}"]`)[0], errors[name]);
                }
            } else if ($(this).is(":radio")) {
                // Si necesitas manejar radios, descomenta lo siguiente
                // if (errors.hasOwnProperty(name)) {
                //     showError($(`[error-name="${name}"]`)[0], errors[name]);
                // }
            } else if ($(this).attr("type") === "file") {
                if (errors.hasOwnProperty(name)) {
                    showError($(`[name="${name}"]`)[0], errors[name]);
                } else if (errors.hasOwnProperty("image")) {
                    $("#error-image").text(errors["image"]);
                }
            } else {
                if (errors.hasOwnProperty(name) && name !== "image") {
                    errors[name].length > 1
                        ? showError($(`[name="${name}"]`)[0], errors[name][0])
                        : showError($(`[name="${name}"]`)[0], errors[name]);
                } else if (value.trim() !== "" && name && name !== "change") {
                    showSucces($(`[name="${name}"]`)[0]);
                }
            }
        });
    },
    initChoice: function (search = false) {
        document.querySelectorAll(".choices").forEach((element, index) => {
            // Use a meaningful key, like the element's ID or a generated unique identifier
            const key = element.id || `choice-${index}`;

            const instance = new Choices(element, {
                // Configuration options
                noChoicesText: "No hay opciones para elegir",
                noResultsText: "No se encontraron resultados",
                shouldSort: false,
                searchEnabled: search,
            });

            // Store instance with a meaningful key
            choiceInstances[key] = instance;
        });
    },
    resetChoice: function () {
        Object.values(choiceInstances).forEach((choice) => {
            choice.setChoiceByValue("");
        });
    },
    getChoiceInstance: function (key) {
        return choiceInstances[key];
    },
    resetForm: function (form) {
        // form.trigger("reset");
        $("form#form-main :input").each(function () {
            let e = $(this);
            if (e.prop("tagName") == "SELECT") {
                e.val("").trigger("change");
                utilities.resetChoice();
            } else if (e.prop("type") === "checkbox") {
                e.prop("checked", false);
            } else if (e.prop("type") === "radio") {
                e.prop("checked", false);
                return;
            } else {
                e.parent().removeClass("is-invalid is-valid is-filled mb-3");
                e.val("");
                if (e.prop("type") === "date") {
                    e.parent().addClass("is-filled");
                }
            }
        });
    },
    ajaxSetup: function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    },
    getByID: function (id, table, id_row) {
        return table
            .rows()
            .data()
            .filter(function (row) {
                return row[id_row] === parseInt(id);
            })[0];
    },
    loaderTool: function () {
        table.addClass("mostrar");
        loader.addClass("oculto");
        loader.hide();
    },
    showToast() {
        var toastElement = $("#infoToast");
        var toast = new bootstrap.Toast(toastElement);
        toast.show();
    },
};

window.languageTable = {
    search: "_INPUT_",
    searchPlaceholder: "Buscar...",
    decimal: "",
    emptyTable: "No hay información",
    info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
    infoFiltered: "(Filtrado de _MAX_ total entradas)",
    infoPostFix: "",
    thousands: ",",
    lengthMenu: "Mostrar _MENU_ Entradas",
    loadingRecords: "Cargando...",
    processing: "Procesando...",
    zeroRecords: "Sin resultados encontrados",
};
$(document).ready(function () {
    const modal = $("#imageModal");
    const modalImg = $("#modalImage");
    const fullscreenBtn = $("#fullscreenBtn");
    let isFullscreen = false;

    $(document).on("click", ".img-preview", function () {
        modalImg.attr("src", $(this).attr("src"));
        modal.css("display", "block");
        setTimeout(() => modal.addClass("show"), 10);
    });

    function closeModal() {
        modal.removeClass("show");
        setTimeout(() => modal.css("display", "none"), 300);
        isFullscreen = false;
        modalImg.removeClass("fullscreen");
    }

    $("#closeBtn").click(closeModal);

    fullscreenBtn.click(function () {
        isFullscreen = !isFullscreen;
        modalImg.toggleClass("fullscreen");
        $(this).html(isFullscreen ? "⤓" : "⤢");
    });

    modal.click(function (e) {
        if (e.target === this) closeModal();
    });

    $(document).keyup(function (e) {
        if (e.key === "Escape") closeModal();
    });
});
