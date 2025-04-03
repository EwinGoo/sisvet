@extends('backend.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 position-relative z-index-2">
            {{-- <div class="card mb-4">
                <div class="d-flex">
                    <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-xl mt-n3 ms-4">
                        <i class="material-icons opacity-10" aria-hidden="true">language</i>
                    </div>
                    <h6 class="mt-3 mb-2 ms-3">Sales by Country {{ __('Read in') }}</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-7">
                            <div class="table-responsive">
                                <table class="table align-items-center">
                                    <tbody>
                                        <tr>
                                            <td class="w-30">
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <div>
                                                        <img src="{{ asset('material-dashboard/assets/img/icons/flags/US.png') }}"
                                                            alt="Country flag" />
                                                    </div>
                                                    <div class="ms-4">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            Country:
                                                        </p>
                                                        <h6 class="text-sm font-weight-normal mb-0">
                                                            United States
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Sales:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        2500
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Value:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        $230,900
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <div class="col text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Bounce:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        29.9%
                                                    </h6>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-30">
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <div>
                                                        <img src="{{ asset('material-dashboard/assets/img/icons/flags/DE.png') }}"
                                                            alt="Country flag" />
                                                    </div>
                                                    <div class="ms-4">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            Country:
                                                        </p>
                                                        <h6 class="text-sm font-weight-normal mb-0">
                                                            Germany
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Sales:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        3.900
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Value:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        $440,000
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <div class="col text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Bounce:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        40.22%
                                                    </h6>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-30">
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <div>
                                                        <img src="{{ asset('material-dashboard/assets/img/icons/flags/GB.png') }}"
                                                            alt="Country flag" />
                                                    </div>
                                                    <div class="ms-4">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            Country:
                                                        </p>
                                                        <h6 class="text-sm font-weight-normal mb-0">
                                                            Great Britain
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Sales:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        1.400
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Value:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        $190,700
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <div class="col text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Bounce:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        23.44%
                                                    </h6>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-30">
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <div>
                                                        <img src="{{ asset('material-dashboard/assets/img/icons/flags/BR.png') }}"
                                                            alt="Country flag" />
                                                    </div>
                                                    <div class="ms-4">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            Country:
                                                        </p>
                                                        <h6 class="text-sm font-weight-normal mb-0">
                                                            Brasil
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Sales:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        562
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Value:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        $143,960
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <div class="col text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Bounce:
                                                    </p>
                                                    <h6 class="text-sm font-weight-normal mb-0">
                                                        32.14%
                                                    </h6>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-5">
                            <div id="map" class="mt-0 mt-lg-n4"></div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row mb-4">
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
                                <span class="text-success text-sm font-weight-bolder">{{ $data['porcentaje_crecimiento'] }}%
                                </span>que el mes anterior
                            </p>
                        </div>
                    </div>
                </div>
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
                {{-- <div class="col-lg-3 col-md-6 col-sm-6 mt-lg-0 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2 bg-transparent">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">person_add</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Citas Hoy</p>
                                <h4 class="mb-0">+91</h4>
                            </div>
                        </div>
                        <hr class="horizontal my-0 dark" />
                        <div class="card-footer p-3">
                            <p class="mb-0">2 pendientes</p>
                        </div>
                    </div>
                </div> --}}
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
            </div>
            <div class="row mb-4">
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
                            <h6 class="mb-0">Website Views</h6>
                            <p class="text-sm">Last Campaign Performance</p>
                            <hr class="dark horizontal" />
                            <div class="d-flex">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm">campaign sent 2 days ago</p>
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
                            <h6 class="mb-0">Daily Sales</h6>
                            <p class="text-sm">
                                (<span class="font-weight-bolder">+15%</span>) increase in
                                today sales.
                            </p>
                            <hr class="dark horizontal" />
                            <div class="d-flex">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm">updated 4 min ago</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mb-3">
                    <div class="card z-index-2">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0">Completed Tasks</h6>
                            <p class="text-sm">Last Campaign Performance</p>
                            <hr class="dark horizontal" />
                            <div class="d-flex">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm">just updated</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mb-3">
                    <div class="card z-index-2">
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="pie-chart" class="chart-canvas" height="300px"></canvas>
                            </div>
                            <h6 class="mb-0">Completed Tasks</h6>
                            <p class="text-sm">Last Campaign Performance</p>
                            <hr class="dark horizontal" />
                            <div class="d-flex">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm">just updated</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // var ctx2 = document.getElementById("chart-line").getContext("2d");

        // new Chart(ctx2, {
        //     type: "line",
        //     data: {
        //         labels: [
        //             "Apr",
        //             "May",
        //             "Jun",
        //             "Jul",
        //             "Aug",
        //             "Sep",
        //             "Oct",
        //             "Nov",
        //             "Dec",
        //         ],
        //         datasets: [{
        //             label: "Mobile apps",
        //             tension: 0,
        //             borderWidth: 0,
        //             pointRadius: 5,
        //             pointBackgroundColor: "rgba(255, 255, 255, .8)",
        //             pointBorderColor: "transparent",
        //             borderColor: "rgba(255, 255, 255, .8)",
        //             borderColor: "rgba(255, 255, 255, .8)",
        //             borderWidth: 4,
        //             backgroundColor: "transparent",
        //             fill: true,
        //             data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
        //             maxBarThickness: 6,
        //         }, ],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false,
        //             },
        //         },
        //         interaction: {
        //             intersect: false,
        //             mode: "index",
        //         },
        //         scales: {
        //             y: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: true,
        //                     drawOnChartArea: true,
        //                     drawTicks: false,
        //                     borderDash: [5, 5],
        //                     color: "rgba(255, 255, 255, .2)",
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: "#f8f9fa",
        //                     padding: 10,
        //                     font: {
        //                         size: 14,
        //                         weight: 300,
        //                         family: "Roboto",
        //                         style: "normal",
        //                         lineHeight: 2,
        //                     },
        //                 },
        //             },
        //             x: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: false,
        //                     drawOnChartArea: false,
        //                     drawTicks: false,
        //                     borderDash: [5, 5],
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: "#f8f9fa",
        //                     padding: 10,
        //                     font: {
        //                         size: 14,
        //                         weight: 300,
        //                         family: "Roboto",
        //                         style: "normal",
        //                         lineHeight: 2,
        //                     },
        //                 },
        //             },
        //         },
        //     },
        // });
    </script>
    {{-- <script>
    var ctx2 = document.getElementById("myChart").getContext("2d");

new Chart(ctx2, {
    type: "line",
    data: {
        labels: <?php echo json_encode($data['labels']); ?>,
        datasets: [{
            label: "Ventas (Bs)",
            tension: 0.4,
            borderWidth: 4,
            pointRadius: 5,
            pointBackgroundColor: "rgba(255, 255, 255, .8)",
            pointBorderColor: "transparent",
            borderColor: "rgba(255, 255, 255, .8)",
            backgroundColor: "transparent",
            fill: true,
            data: <?php echo json_encode($data['data']); ?>,
            maxBarThickness: 6,
        }],
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

</script> --}}
@endsection

@section('scripts')
    <script>
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
    </script>
@endsection
