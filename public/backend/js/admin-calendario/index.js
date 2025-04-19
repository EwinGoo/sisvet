document.addEventListener("DOMContentLoaded", function () {
    // Inicialización del calendario
    // Inicializar gráfico
    let productivityChart;
    let chartRange = "semanal";

    // Elementos del DOM
    const ctx = document.getElementById("productivityChart").getContext("2d");
    const rangeButtons = document.querySelectorAll(".chart-range-btn");
    const productivityPercent = document.getElementById("productivityPercent");
    const productivitySubtitle = document.getElementById(
        "productivitySubtitle"
    );

    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "es",
        timeZone: "local",
        initialView: "dayGridMonth",
        contentHeight: "auto",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        buttonText: {
            today: "hoy",
            month: "mes",
            week: "semana",
            day: "día",
        },
        editable: true,
        selectable: true,
        events: function (fetchInfo, successCallback, failureCallback) {
            getCitasCalendario(fetchInfo.start, fetchInfo.end)
                .then(successCallback)
                .catch(failureCallback);
        },
        eventDrop: function (info) {
            updateCita(info.event);
        },
        eventResize: function (info) {
            updateCita(info.event);
        },
        eventClick: function (info) {
            showEventDetails(info.event);
        },
        eventDidMount: function (info) {
            initTooltip(info.el, info.event);
        },
    });

    calendar.render();

    cargarProximosEventos();

    initChart();

    // Event listeners para los botones de rango
    rangeButtons.forEach((btn) => {
        btn.addEventListener("click", function () {
            rangeButtons.forEach((b) => b.classList.remove("active"));
            this.classList.add("active");
            chartRange = this.dataset.range;
            updateChartData();
        });
    });

    // Configurar evento de refresco
    document
        .getElementById("refreshEvents")
        .addEventListener("click", cargarProximosEventos);

    // Recargar cada 5 minutos
    setInterval(cargarProximosEventos, 300000);

    /**
     * Obtiene las citas para el calendario mediante AJAX
     * @param {Date} start - Fecha de inicio
     * @param {Date} end - Fecha de fin
     * @returns {Promise} Promesa con los datos de las citas
     */
    function getCitasCalendario(start, end) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "/admin/calendario",
                method: "GET",
                dataType: "json",
                data: {
                    start: start.toISOString(),
                    end: end.toISOString(),
                },
                success: function (response) {
                    if (response && Array.isArray(response)) {
                        resolve(response);
                    } else {
                        reject(new Error("Formato de respuesta inválido"));
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error al obtener citas:", error);
                    reject(new Error("Error al cargar las citas"));
                },
            });
        });
    }

    /**
     * Actualiza una cita (fecha/hora o duración)
     * @param {Event} event - Objeto evento de FullCalendar
     */
    function updateCita(event) {
        const data = {
            _token: $('meta[name="csrf-token"]').attr("content"),
            start: event.start.toISOString(),
            end: event.end
                ? event.end.toISOString()
                : event.start.toISOString(),
        };

        $.ajax({
            url: `/admin/calendario/${event.id}`,
            method: "PUT",
            dataType: "json",
            data: data,
            success: function (response) {
                // toastr.success("Cita actualizada correctamente");
                showToast(response.message);
            },
            error: function (xhr) {
                calendar.refetchEvents();

                if (xhr.status === 409) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("Error al actualizar la cita");
                }
            },
        });
    }

    /**
     * Muestra los detalles de una cita en un modal
     * @param {Event} event - Objeto evento de FullCalendar
     */
    function showEventDetails(event) {
        const props = event.extendedProps;
        console.log(props);

        const startDate = new Date(event.start);
        $("#modal-main").modal("show");
        $("#modalTitle").text(`${props.mascota} - ${props.tipo_consulta}`);
        $("#modalBody").html(`
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Propietario:</strong> ${props.propietario}</p>
                    <p><strong>Mascota:</strong> ${props.mascota}</p>
                    <p><strong>Tipo consulta:</strong> ${
                        props.tipo_consulta
                    }</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Estado:</strong> <span class="badge bg-${getStatusColor(
                        props.estado
                    )}">${props.estado}</span></p>
                    <p><strong>Fecha:</strong> ${startDate.toLocaleDateString(
                        "es-ES",
                        {
                            weekday: "long",
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                        }
                    )}</p>
                    <p><strong>Hora:</strong> ${startDate.toLocaleTimeString(
                        "es-ES",
                        { hour: "2-digit", minute: "2-digit" }
                    )}</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <p><strong>Motivo:</strong></p>
                    <p>${props.motivo}</p>
                </div>
            </div>
        `);

        $("#eventModal").modal("show");
    }

    /**
     * Inicializa el tooltip para un evento
     * @param {HTMLElement} element - Elemento del evento
     * @param {Event} event - Objeto evento de FullCalendar
     */
    function initTooltip(element, event) {
        $(element).tooltip({
            title: buildTooltipContent(event),
            html: true,
            placement: "top",
            container: "body",
        });
    }

    /**
     * Construye el contenido del tooltip
     * @param {Event} event - Objeto evento de FullCalendar
     * @returns {string} HTML del tooltip
     */
    function buildTooltipContent(event) {
        const props = event.extendedProps;
        const startDate = new Date(event.start);

        return `
            <div class="text-left">
                <p class="mb-1"><strong>${props.mascota}</strong></p>
                <p class="mb-1"><small>${props.tipo_consulta}</small></p>
                <p class="mb-1"><small>${startDate.toLocaleTimeString("es-ES", {
                    hour: "2-digit",
                    minute: "2-digit",
                })}</small></p>
                <p class="mb-0"><span class="badge bg-${getStatusColor(
                    props.estado
                )}">${props.estado}</span></p>
            </div>
        `;

        return;
    }

    /**
     * Devuelve el color correspondiente al estado de la cita
     * @param {string} status - Estado de la cita
     * @returns {string} Clase de color de Bootstrap
     */
    function getStatusColor(status) {
        const statusColors = {
            Pendiente: "warning",
            Confirmada: "success",
            Completada: "info",
            Cancelada: "danger",
        };
        return statusColors[status] || "primary";
    }

    function showToast(message) {
        $("#infoToast div:last").text(message);
        new bootstrap.Toast($("#infoToast"), { delay: 2500 }).show();
    }

    function cargarProximosEventos() {
        const container = document.getElementById("proximosEventosContainer");
        container.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        `;

        fetch("/admin/calendario/proximos-eventos")
            .then((response) => {
                if (!response.ok) throw new Error("Error al cargar eventos");
                return response.json();
            })
            .then((eventos) => {
                if (eventos.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-4">
                            <p class="text-muted">No hay citas próximas</p>
                        </div>
                    `;
                    return;
                }

                let html = "";
                eventos.forEach((evento, index) => {
                    const fecha = new Date(evento.fecha);
                    const fechaFormateada = fecha.toLocaleDateString("es-ES", {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                        hour: "2-digit",
                        minute: "2-digit",
                    });

                    html += `
                        <div class="d-flex ${index > 0 ? "mt-4" : ""}">
                            <div class="icon icon-shape bg-gradient-${getColorByStatus(
                                evento.estado
                            )} shadow text-center">
                                <i class="material-icons opacity-10 pt-1">${
                                    evento.icono
                                }</i>
                            </div>
                            <div class="ms-3">
                                <div class="numbers">
                                    <h6 class="mb-1 text-dark text-sm">${
                                        evento.titulo
                                    }</h6>
                                    <span class="text-sm">${fechaFormateada}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            })
            .catch((error) => {
                console.error("Error:", error);
                container.innerHTML = `
                    <div class="text-center py-4">
                        <p class="text-danger">Error al cargar las citas</p>
                        <button onclick="cargarProximosEventos()" class="btn btn-sm btn-primary">
                            Reintentar
                        </button>
                    </div>
                `;
            });
    }

    function getColorByStatus(status) {
        const statusColors = {
            Pendiente: "warning",
            Confirmada: "success",
            Completada: "info",
            Cancelada: "danger",
        };
        return statusColors[status] || "primary";
    }

    function initChart() {
        productivityChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [],
                datasets: [],
            },
            options: getChartOptions(),
        });

        updateChartData();
    }

    // Función para actualizar los datos del gráfico
    function updateChartData() {
        fetch(`/admin/calendario/estadisticas-productividad?rango=${chartRange}`)
            .then((response) => response.json())
            .then((data) => {
                // Actualizar datos del gráfico
                productivityChart.data.labels = data.labels;
                productivityChart.data.datasets = data.datasets;
                productivityChart.update();

                // Calcular y mostrar porcentaje de mejora
                updateProductivityPercentage(data.datasets);
            })
            .catch((error) => {
                console.error("Error al cargar datos:", error);
            });
    }

    // Función para calcular el porcentaje de productividad
    function updateProductivityPercentage(datasets) {
        if (datasets.length < 1 || datasets[0].data.length < 2) return;

        const totalCitas = datasets[0].data;
        const lastWeek = totalCitas[totalCitas.length - 1];
        const prevWeek = totalCitas[totalCitas.length - 2] || 1;

        const percentChange = Math.round(
            ((lastWeek - prevWeek) / prevWeek) * 100
        );

        productivityPercent.textContent = `${Math.abs(percentChange)}%`;

        if (percentChange > 0) {
            productivitySubtitle.innerHTML = `
                <i class="material-icons text-success text-sm">arrow_upward</i>
                <span class="font-weight-bold">${Math.abs(
                    percentChange
                )}%</span> más que el período anterior
            `;
        } else {
            productivitySubtitle.innerHTML = `
                <i class="material-icons text-danger text-sm">arrow_downward</i>
                <span class="font-weight-bold">${Math.abs(
                    percentChange
                )}%</span> menos que el período anterior
            `;
        }
    }

    // Configuración del gráfico
    function getChartOptions() {
        return {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        color: "#fff",
                        font: {
                            size: 10,
                        },
                        boxWidth: 10,
                        padding: 10,
                    },
                },
                tooltip: {
                    backgroundColor: "#344767",
                    titleColor: "#fff",
                    bodyColor: "#fff",
                    borderColor: "#67748e",
                    borderWidth: 1,
                    padding: 12,
                    usePointStyle: true,
                    callbacks: {
                        label: function (context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        },
                    },
                },
            },
            interaction: {
                intersect: false,
                mode: "index",
            },
            scales: {
                y: {
                    grid: {
                        color: "rgba(255, 255, 255, 0.1)",
                        drawBorder: false,
                        zeroLineColor: "rgba(255, 255, 255, 0.1)",
                    },
                    ticks: {
                        color: "#fff",
                        font: {
                            size: 10,
                        },
                        callback: function (value) {
                            return Number.isInteger(value) ? value : "";
                        },
                    },
                },
                x: {
                    grid: {
                        color: "rgba(255, 255, 255, 0.1)",
                        drawBorder: false,
                    },
                    ticks: {
                        color: "#fff",
                        font: {
                            size: 10,
                        },
                    },
                },
            },
        };
    }

    // Actualizar cada hora
    setInterval(updateChartData, 3600000);
});
