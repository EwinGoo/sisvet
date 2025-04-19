@extends('backend.app')
@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card card-calendar">
                <div class="card-body p-3">
                    <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="row">
                <div class="col-xl-12 col-md-6 mt-xl-0 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Próximas Citas</h6>
                                <button id="refreshEvents" class="btn btn-sm btn-outline-secondary">
                                    <i class="material-icons opacity-10 text-md">refresh</i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body border-radius-lg p-3" id="proximosEventosContainer">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ... resto de tu código ... -->
                <div class="col-xl-12 col-md-6 mt-4">
                    <div class="card bg-gradient-dark">
                        <div class="card-header bg-transparent p-3 pb-0">
                            <div class="row">
                                <div class="col-7">
                                    <h6 class="text-white mb-0">Productividad</h6>
                                    <p class="text-sm text-white" id="productivitySubtitle">
                                </div>
                                <div class="col-5 text-end">
                                    <div class="dropdown me-3">
                                        <a class="cursor-pointer" href="javascript:;" id="dropdownChartRange"
                                            data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                            <i class="material-icons text-white text-sm">settings</i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end ms-n5 px-2 py-3"
                                            aria-labelledby="dropdownChartRange">
                                            <li><a class="dropdown-item border-radius-md chart-range-btn active"
                                                    href="javascript:;" data-range="semanal">Semanal</a></li>
                                            <li><a class="dropdown-item border-radius-md chart-range-btn"
                                                    href="javascript:;" data-range="mensual">Mensual</a></li>
                                            <li><a class="dropdown-item border-radius-md chart-range-btn"
                                                    href="javascript:;" data-range="anual">Anual</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="chart">
                                <canvas id="productivityChart" class="chart-canvas" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.consultorio.cita.modal-calendario')
@endsection
@section('scripts')
    <script></script>
@endsection
