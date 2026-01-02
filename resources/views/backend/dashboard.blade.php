@extends('backend.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 position-relative z-index-2">
            <div class="row mb-4">
                @if ($usuario->rol === 'médico' || $usuario->rol === 'administrador')
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">medication</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Total Pacientes</p>
                                    <h4 class="mb-0">{{ $data['total_mascotas'] }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0" />
                            <div class="card-footer p-3">
                                <p class="mb-0">
                                    <span
                                        class="text-success text-sm font-weight-bolder">{{ $data['porcentaje_crecimiento'] }}%
                                    </span>que el mes anterior
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($usuario->rol === 'vendedor' || $usuario->rol === 'administrador')
                    <div class="col-lg-3 col-md-6 col-sm-6 mt-lg-0 mt-4">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2 bg-transparent">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">store</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Ventas del Día</p>
                                    <h4 class="mb-0">Bs. {{ $data['total_vendido'] }}</h4>
                                </div>
                            </div>
                            <hr class="horizontal my-0 dark" />
                            <div class="card-footer p-3">
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">{{ $data['porcentaje_vendido'] }}%
                                    </span>que ayer
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($usuario->rol === 'médico' || $usuario->rol === 'administrador')
                    <div class="col-lg-3 col-md-6 col-sm-6 mt-lg-0 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2 bg-transparent">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">person_add</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Citas Hoy</p>
                                    <h4 class="mb-0">{{ $data['citas_hoy'] }}</h4>
                                </div>
                            </div>
                            <hr class="horizontal my-0 dark" />
                            <div class="card-footer p-3">
                                <p class="mb-0">{{ $data['citas_pendientes'] }} pendientes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mt-lg-0 mt-4">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">weekend</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Nuevas mascotas</p>
                                    <h4 class="mb-0">{{ $data['mascotas_registradas_hoy'] }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0" />
                            <div class="card-footer p-3">
                                <p class="mb-0">Registradas hoy
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row mb-4">
                @if ($usuario->rol === 'vendedor' || $usuario->rol === 'administrador')
                    <div class="col-lg-6 col-md-6 mt-4 mb-4">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <div class="chart">
                                        <canvas id="chart-bars" class="chart-canvas" height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-0">Ventas esta semana</h6>
                                <p class="text-sm">Cantidad de ventas por dia esta semana</p>
                                <hr class="dark horizontal" />
                                <div class="d-flex">
                                    <i class="material-icons text-sm my-auto me-1">schedule</i>
                                    <p class="mb-0 text-sm">Actualizado hoy a las <?= date('H:i:s') ?> hs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mt-4 mb-4">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                                    <div class="chart">
                                        <canvas id="chart-line" class="chart-canvas" height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-0">Ventas Mensuales (Bs)</h6>
                                <p class="text-sm font-medium">
                                    Total de ventas mensuales (expresado en Bs)
                                </p>

                                <hr class="dark horizontal" />
                                <div class="d-flex">
                                    <i class="material-icons text-sm my-auto me-1">schedule</i>
                                    <p class="mb-0 text-sm">Actualizado hoy a las <?= date('H:i:s') ?> hs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($usuario->rol === 'médico' || $usuario->rol === 'administrador')
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-0">Vacunas Aplicadas</h6>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-bar" class="chart-canvas" height="340"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-0">Tipos de Consulta</h6>
                                </div>
                            </div>
                            <div class="card-body pb-0 p-3 mt-4">
                                <div class="row">
                                    <div class="col-7 text-start">
                                        <div class="chart">
                                            <canvas id="chart-pie" class="chart-canvas" height="200"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-5 my-auto">
                                        @foreach ($data['citas_data'] as $item)
                                            <span class="badge badge-md badge-dot me-4 d-block text-start">
                                                <i class="bg-{{ $loop->index }}"
                                                    style="background-color: {{ $item['color'] }}"></i>
                                                <span class="text-dark text-xs">
                                                    {{ $item['tipo'] }} ({{ $item['porcentaje'] }}%)
                                                </span>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer pt-0 pb-0 p-3 d-flex align-items-center">
                                <div class="w-100">
                                    <p class="text-sm">
                                        Distribución porcentual de los tipos de atención veterinaria realizadas
                                        en el último periodo.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($usuario->rol === 'vendedor' || $usuario->rol === 'administrador')
                    <div class="col-lg-12 col-sm-6 mt-4">
                        <div class="card">
                            <div class="card-header pb-0 p-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-0">Estado del Inventario</h6>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-line-2" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        if (@json($usuario->rol) == 'vendedor' || @json($usuario->rol) == 'administrador') {
            var ctx2 = document.getElementById("chart-line").getContext("2d");

            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: @json($data['labels']),
                    datasets: [{
                        label: "Ventas (Bs)",
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: @json($data['data']),
                        maxBarThickness: 6,
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: "index",
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: "rgba(255, 255, 255, .2)",
                            },
                            ticks: {
                                display: true,
                                color: "#f8f9fa",
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5],
                            },
                            ticks: {
                                display: true,
                                color: "#f8f9fa",
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                    },
                },
            });
        }
        if (@json($usuario->rol) == 'vendedor' || @json($usuario->rol) == 'administrador') {
            var ctx = document.getElementById("chart-bars").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["L", "M", "M", "J", "V", "S", "D"],
                    datasets: [{
                        label: "Ventas",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: @json($data['ventas_semana']),
                        maxBarThickness: 6,
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: "index",
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: "rgba(255, 255, 255, .2)",
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                                color: "#fff",
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: "rgba(255, 255, 255, .2)",
                            },
                            ticks: {
                                display: true,
                                color: "#f8f9fa",
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                    },
                },
            });
        }
        if (@json($usuario->rol) == 'médico' || @json($usuario->rol) == 'administrador') {
            var ctx3 = document.getElementById("chart-bar").getContext("2d");
            new Chart(ctx3, {
                type: "bar",
                data: {
                    labels: @json($data['vacunas']['labels']),
                    datasets: [{
                        label: "Cantidad",
                        weight: 5,
                        borderWidth: 0,
                        borderRadius: 4,
                        backgroundColor: "#3A416F",
                        data: @json($data['vacunas']['data']),
                        fill: false,
                    }, ],
                },
                options: {
                    indexAxis: "y",
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: "#c1c4ce5c",
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: "#c1c4ce5c",
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: true,
                                drawTicks: true,
                                color: "#9ca2b7",
                            },
                            ticks: {
                                display: true,
                                color: "#9ca2b7",
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                        y: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: true,
                                drawTicks: true,
                                color: "#9ca2b7",
                            },
                            ticks: {
                                display: true,
                                color: "#9ca2b7",
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                    },
                },
            });
        }
        if (@json($usuario->rol) == 'médico' || @json($usuario->rol) == 'administrador') {
            var ctx4 = document.getElementById("chart-pie").getContext("2d");
            new Chart(ctx4, {
                type: "pie",
                data: {
                    labels: @json($data['citas_por_tipo']['labels']),
                    datasets: [{
                        label: "Projects",
                        weight: 9,
                        cutout: 0,
                        tension: 0.9,
                        pointRadius: 2,
                        borderWidth: 1,
                        backgroundColor: @json($data['citas_por_tipo']['colores']),
                        data: @json($data['citas_por_tipo']['data']),
                        fill: false,
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: "index",
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                color: "#c1c4ce5c",
                            },
                            ticks: {
                                display: false,
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                color: "#c1c4ce5c",
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    },
                },
            });
        }
        if (@json($usuario->rol) == 'vendedor' || @json($usuario->rol) == 'administrador') {
            var ctx5 = document.getElementById("chart-line-2").getContext("2d");
            new Chart(ctx5, {
                type: "bar",
                data: {
                    labels: @json($data['inventario']['labels']),
                    datasets: [{
                            label: "Facebook Ads",
                            tension: 0,
                            pointRadius: 5,
                            pointBackgroundColor: "#e91e63",
                            pointBorderColor: "transparent",
                            borderColor: "#e91e63",
                            borderWidth: 4,
                            backgroundColor: "transparent",
                            fill: true,
                            //   data: [50, 100, 200, 190, 400, 350, 500, 450, 700],
                            maxBarThickness: 6,
                        },
                        {
                            label: "Stock",
                            tension: 0,
                            borderWidth: 0,
                            pointRadius: 5,
                            pointBackgroundColor: "#3A416F",
                            pointBorderColor: "transparent",
                            borderColor: "#3A416F",
                            borderWidth: 4,
                            backgroundColor: "transparent",
                            fill: true,
                            data: @json($data['inventario']['data']),
                            maxBarThickness: 6,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: "index",
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: "#c1c4ce5c",
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: "#9ca2b7",
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: true,
                                borderDash: [5, 5],
                                color: "#c1c4ce5c",
                            },
                            ticks: {
                                display: true,
                                color: "#9ca2b7",
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                    },
                },
            });
        }
    </script>
@endsection
