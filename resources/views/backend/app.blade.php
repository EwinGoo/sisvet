<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset('assets/images/vet.ico') }}" />
    <title style="text-transform: capitalize">Sistema Vet | {{ ucwords($title) }} </title>


    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/css/typography.css') }}" /> --}}
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link href="{{ asset('material-dashboard/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('material-dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
    {{-- <script src="{{ asset('assets/js/42d5adcbca.js') }}" crossorigin="anonymous"></script> --}}

    {{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/css/icon.css') }}" rel="stylesheet" />
    <link id="pagestyle"
        href="{{ asset('material-dashboard/assets/css/material-dashboard.min.css?v=3.0.6') }}"rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('material-dashboard/assets/css/datatable.responsive.css') }}"rel="stylesheet" />
    <link href="{{ asset('assets/css/global.styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/image-preview.css') }}" rel="stylesheet" />

    {{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}
    <script src="{{ asset('material-dashboard/assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/datatables.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/datatables.responsive.js') }}"></script>

</head>

<body class="g-sidenav-show bg-gray-200">
    @include('backend.layouts.menu')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('backend.layouts.header')
        <div class="container-fluid py-4">
            <div class="row">
                @yield('content')
            </div>
            @include('backend.layouts.footer')
        </div>
        <div class="modal-image" id="imageModal">
            <img class="modal-image-content" id="modalImage" src="" alt="Modal Image">
            <div class="modal-image-controls">
                <button class="modal-image-btn" id="fullscreenBtn">⤢</button>
                <button class="modal-image-btn" id="closeBtn">×</button>
            </div>
        </div>
    </main>
    <div class="position-fixed top-1 end-1 z-index-1030">
        <div class="toast fade hide p-2 mt-2 bg-gradient-info" role="alert" aria-live="assertive" id="infoToast"
            aria-atomic="true">
            <div class="toast-header bg-transparent border-0">
                <i class="material-icons text-white me-2"> notifications </i>
                <span class="me-auto text-white font-weight-bold">Notificación</span>
                <i class="fas fa-times text-md text-white ms-3 cursor-pointer" data-bs-dismiss="toast"
                    aria-label="Close"></i>
            </div>
            <hr class="horizontal light m-0" />
            <div class="toast-body text-white"></div>
        </div>
    </div>
    {{-- <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-icons py-2">settings</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Material UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
            </div>
            <hr class="horizontal dark my-1" />
            <div class="card-body pt-sm-3 pt-0">
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>

                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark"
                        onclick="sidebarType(this)">
                        Dark
                    </button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent"
                        onclick="sidebarType(this)">
                        Transparent
                    </button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">
                        White
                    </button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">
                    You can change the sidenav type just on desktop view.
                </p>

                <div class="mt-3 d-flex">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)" />
                    </div>
                </div>
                <hr class="horizontal dark my-3" />
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Sidenav Mini</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarMinimize"
                            onclick="navbarMinimize(this)" />
                    </div>
                </div>
                <hr class="horizontal dark my-3" />
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)" />
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4" />
                <a class="btn bg-gradient-primary w-100"
                    href="https://www.creative-tim.com/product/material-dashboard-pro">Buy now</a>
                <a class="btn bg-gradient-info w-100"
                    href="https://www.creative-tim.com/product/material-dashboard">Free demo</a>
                <a class="btn btn-outline-dark w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View
                    documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                        data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20PRO%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard-pro"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard-pro"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i>
                        Share
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    <script src="{{ asset('material-dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/datatables.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/datatables.responsive.js') }}"></script>
    {{-- <script src="{{ asset('material-dashboard/assets/js/plugins/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('material-dashboard/assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/fullcalendar.min.js') }}"></script>

    <script src="{{ asset('material-dashboard/assets/js/plugins/dragula/dragula.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/jkanban/jkanban.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/world.js') }}"></script>


    @if ($page == 'dashboard')
        <script>
            var ctx = document.getElementById("chart-bars").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["M", "T", "W", "T", "F", "S", "S"],
                    datasets: [{
                        label: "Sales",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: [50, 20, 10, 22, 50, 10, 40],
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

            var ctx2 = document.getElementById("chart-line").getContext("2d");

            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: [
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                    datasets: [{
                        label: "Mobile apps",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
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

            var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

            new Chart(ctx3, {
                type: "line",
                data: {
                    labels: [
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                    datasets: [{
                        label: "Mobile apps",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
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
                                padding: 10,
                                color: "#f8f9fa",
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

            // Initialize the vector map
            var map = new jsVectorMap({
                selector: "#map",
                map: "world_merc",
                zoomOnScroll: false,
                zoomButtons: false,
                selectedMarkers: [1, 3],
                markersSelectable: true,
                markers: [{
                        name: "USA",
                        coords: [40.71296415909766, -74.00437720027804],
                    },
                    {
                        name: "Germany",
                        coords: [51.17661451970939, 10.97947735117339],
                    },
                    {
                        name: "Brazil",
                        coords: [-7.596735421549542, -54.781694323779185],
                    },
                    {
                        name: "Russia",
                        coords: [62.318222797104276, 89.81564777631716],
                    },
                    {
                        name: "China",
                        coords: [22.320178999475512, 114.17161225541399],
                        style: {
                            fill: "#E91E63",
                        },
                    },
                ],
                markerStyle: {
                    initial: {
                        fill: "#e91e63",
                    },
                    hover: {
                        fill: "E91E63",
                    },
                    selected: {
                        fill: "E91E63",
                    },
                },
            });
        </script>
    @endif

    <script>
        var win = navigator.platform.indexOf("Win") > -1;
        if (win && document.querySelector("#sidenav-scrollbar")) {
            var options = {
                damping: "0.5",
            };
            Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
        }
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('material-dashboard/assets/js/material-dashboard.min.js?v=3.0.6') }}"></script>
    <script src="{{ asset('assets/js/image-preview.js') }}"></script>
    <script src="{{ asset('assets/js/global.scripts.js') }}"></script>
    <script src="{{ asset('backend/js/components/alerts.js') }}"></script>
    @if ($pageURL)
        {{-- @vite('public/backend/js/' . $page . '/index.js') --}}
    <script src="{{ asset('backend/js/' . $pageURL . '/index.js') }}" type="module"></script>
    @elseif($page && $page !== 'dashboard' && $pageURL == null)
    <script src="{{ asset('backend/js/' . $page . '/index.js') }}" type="module"></script>
    @endif

    @if (strpos($pageURL, "detalle-venta") !== false)
    <script src="{{ asset('backend/js/tienda/admin-cliente/index.js') }}" type="module"></script>
    @endif

</body>

</html>
