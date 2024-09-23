@extends('frontend.app')
@section('content')
    <style>
        .az-contenedor {
            position: static;
            height: auto;
        }
    </style>
    <div class="loader-container">
        <div class="loader">
            <span>Cargando...</span>
        </div>
    </div>
    <div class="az-contenedor az-resultados" style="background: #000;">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <img src="{{ asset('assets/images/banner6.jpg') }}" alt="" style="top: 0rem; z-index: 1;">
                    <div class="col-md-12">
                        <h3 class="title">Hola <b style="color:cyan;">{{ $data['estudiante']->nombre }}</b>, estos son su
                            historial de pruebas realizadas recientemente:</h3>
                    </div>
                    <div class="col-md-12" style="z-index: 99;">
                        <div class="form-container az-table">
                            <div class="table-container" id="scrollable-container" style="overflow: inherit;">
                                @if (!$data['respuestas']->isEmpty())
                                    <table class="table-responsive table-bordered">
                                        <thead>
                                            <tr style="border-top: 0">
                                                <th scope="col">TEST</th>
                                                <th scope="col" class="text-center">FECHA</th>
                                                <th scope="col" class="text-center">HORA</th>
                                                <th scope="col" class="text-center">TIEMPO</th>
                                                <th scope="col" class="text-center">ACCION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['respuestas'] as $main)
                                                <tr style="padding: 1rem">
                                                    <th scope="row" style="min-width: 8rem; padding: 1.5rem;">
                                                        {{ $main['test'] }}</th>
                                                    <td class="az-info">
                                                        <h5 class="az-h5">
                                                            {{ date('Y-m-d', strtotime($main['created_at'])) }}</h5>
                                                    </td>
                                                    <td class="az-info">
                                                        <h5 class="az-h5">
                                                            {{ date('H:i:s', strtotime($main['created_at'])) }}</h5>
                                                    </td>
                                                    <td class="az-info">
                                                        <h5 class="az-h5">
                                                            {{ $main['tiempo'] }}</h5>
                                                    </td>
                                                    <td class="az-info">
                                                        @if ($main['id_test'] == '1')
                                                            <form target="_blank" action="{{ route('resultado') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="id_respuesta"
                                                                    value={{ $main['id_respuesta'] }}>
                                                                <button type="submit"
                                                                    class="btn btn-next w-100  text-center"
                                                                    style="height: 1.5rem;">Revisar</button>
                                                            </form>
                                                        @elseif ($main['id_test'] == '3')
                                                            <form target="_blank"
                                                                action="{{ route('resultado-inteligencia') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="created_at"
                                                                    value="{{ $main['created_at'] }}">
                                                                <button type="submit"
                                                                    class="btn btn-next w-100  text-center"
                                                                    style="height: 1.5rem;">Revisar</button>
                                                            </form>
                                                        @else
                                                            <form target="_blank" action="{{ route('resultado-chaside') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="created_at"
                                                                    value="{{ $main['created_at'] }}">
                                                                <button type="submit"
                                                                    class="btn btn-next w-100  text-center"
                                                                    style="height: 1.5rem;">Revisar</button>
                                                            </form>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h3>Aún no has realizado ningún test.</h3>
                                    <a href="{{ route('/') }}" class="btn btn-next mt-2" style="font-size: 11px">Volver
                                        al inicio</a>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Inicializa Perfect Scrollbar
        document.getElementById('downloadPDF').addEventListener('click', function() {
            var form = document.getElementById("form-main");
            var url = form.action;
            form.setAttribute("target", "_blank");
            form.submit();
            form.removeAttribute("target");
        });
    </script>
@endsection
