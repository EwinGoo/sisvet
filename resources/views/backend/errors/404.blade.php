<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset('assets/images/vet.ico') }}" />
    <title style="text-transform: capitalize">Sistema Veterinario</title>
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <link id="pagestyle"
        href="{{ asset('material-dashboard/assets/css/material-dashboard.min.css?v=3.0.6') }}"rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-200">
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/uploads/1413399939678471ea070/2c0343f7?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-12 m-auto text-center">
                        <h1 class="display-1 text-bolder text-white">Error 404</h1>
                        <h2 class="text-white">Recurso no encontrado</h2>
                        <p class="lead text-white">Le sugerimos que volver a la página de inicio</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-white mt-4">Ir a la página de
                            inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
