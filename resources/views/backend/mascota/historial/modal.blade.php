<div class="modal fade" id="modal-main" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div id="modal-size" class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-md" id="modal-title"></h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-1" id="modal-content">
                {{-- @include('backend.mascota.historial.examen-form') --}}
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

{{-- <script>
    const modal = $("#imageModal");
    const modalImg = $("#modalImage");
    const fullscreenBtn = $("#fullscreenBtn");
    let isFullscreen = false;

    $(".img-preview").click(function () {
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
</script> --}}
