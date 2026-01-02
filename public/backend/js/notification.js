class NotificationManager {
    constructor() {
        this.init();
        this.setupAjaxInterceptor();
    }

    init() {
        this.loadNotifications();
        this.setupEventListeners();
        this.setupRealTime();
    }

    loadNotifications() {
        $.get("/admin/notificaciones", (data) => {
            $("#notifications-loading").hide();

            if (data.length === 0) {
                $("#no-notifications").removeClass("d-none");
                return;
            }
            $("#notifications-items").empty();
            data.forEach((notif) => this.addNotificationToDropdown(notif));
        });
    }

    addNotificationToDropdown(notification) {
        const isUnread = !notification.leida;
        const notificationItem = `
        <li class="mb-2 notification-item ${
            isUnread ? "unread" : "read"
        }" data-id="${notification.id_notificacion}">
            <a class="dropdown-item border-radius-md" href="javascript:;">
                <div class="d-flex align-items-center py-1">
                    <span class="material-icons ${
                        isUnread ? "text-primary" : "text-secondary"
                    }">${this.getNotificationIcon(notification.tipo)}</span>
                    <div class="ms-2">
                        <h6 class="text-sm font-weight-normal my-auto ${
                            isUnread ? "text-dark" : "text-muted"
                        }">
                            ${notification.titulo}
                            ${
                                isUnread
                                    ? '<span class="badge badge-sm bg-primary ms-2">Nuevo</span>'
                                    : ""
                            }
                        </h6>
                        <p class="text-xs mb-0 ${
                            isUnread ? "text-dark" : "text-secondary"
                        }">
                            ${notification.mensaje}
                        </p>
                        <small class="text-xs ${
                            isUnread ? "text-primary" : "text-muted"
                        }">${this.formatDate(notification.created_at)}</small>
                    </div>
                </div>
            </a>
        </li>
    `;
        $("#notifications-items").append(notificationItem);
        this.actualizarContadorNotificaciones();
    }

    getNotificationIcon(type) {
        const icons = {
            stock: "warning",
            venta: "shopping_cart",
            sistema: "info",
        };
        return icons[type] || "notifications";
    }

    formatDate(dateString) {
        // Implementa formato de fecha según tus necesidades
        return new Date(dateString).toLocaleString();
    }

    setupEventListeners() {
        $(document).on("click", ".notification-item", (e) => {
            const notificationId = $(e.currentTarget).data("id");
            this.markAsRead(notificationId);
        });
        // Cerrar dropdown después de hacer click (opcional)
        // $(document).on("click", "#dropdownMenuButton", function (e) {
        //     e.stopPropagation(); // Evita que se cierre inmediatamente
        // });

        // // Cerrar dropdown cuando se hace click fuera
        // $(document).click(function () {
        //     $(".dropdown-menu").hide();
        // });
    }

    markAsRead(notificationId) {
        $.post(`/admin/notificaciones/marcar-leida/${notificationId}`, () => {
            const $notification = $(
                `.notification-item[data-id="${notificationId}"]`
            );
            $notification
                .removeClass("unread")
                .addClass("read")
                .find(".material-icons")
                .removeClass("text-primary")
                .addClass("text-secondary");

            $notification
                .find("h6")
                .removeClass("text-dark")
                .addClass("text-muted");
            $notification
                .find("p")
                .removeClass("text-dark")
                .addClass("text-secondary");
            $notification
                .find("small")
                .removeClass("text-primary")
                .addClass("text-muted");
            $notification.find(".badge").remove(); // Elimina el badge "Nuevo"

            this.actualizarContadorNotificaciones();
        });
    }

    setupRealTime() {
        if (window.Echo) {
            const userId = document.querySelector(
                'meta[name="user-id"]'
            ).content;

            window.Echo.private(`notificaciones.${userId}`).listen(
                ".stock.bajo",
                (data) => {
                    this.showToastNotification(data.notificacion);
                    this.addNotificationToDropdown(data.notificacion);
                    this.actualizarContadorNotificaciones();
                }
            );
        }
    }
    setupAjaxInterceptor() {
        $(document).ajaxSuccess((event, xhr, settings) => {
            // Detectar cuando se completa un POST exitoso
            if (settings.type && settings.type.toLowerCase() === "post") {
                console.log("POST detectado, actualizando notificaciones...");
                this.loadNotifications();
            }
        });
    }

    showToastNotification(notification) {
        // Implementa según tu librería de notificaciones preferida
        console.log("Nueva notificación:", notification);
    }

    actualizarContadorNotificaciones() {
        $.get("/admin/notificaciones/contar", (data) => {
            const $badge = $(".notification-count");
            if (data.count > 0) {
                $badge.text(data.count);
                $badge.addClass(
                    "badge rounded-pill bg-danger border border-white small"
                );
            } else {
                $badge.removeClass(
                    "badge rounded-pill bg-danger border border-white small"
                );
                $badge.text("");
            }
        });
    }
}

// Inicializar cuando el DOM esté listo
$(document).ready(() => {
    new NotificationManager();
});
