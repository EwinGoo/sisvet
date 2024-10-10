<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../../assets/img/favicon.png">
    <title>
        Sistema OV | Login
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />

    <meta name="keywords"
        content="creative tim, html dashboard, html css dashboard, web dashboard, bootstrap 5 dashboard, bootstrap 5, css3 dashboard, bootstrap 5 admin, material dashboard bootstrap 5 dashboard, frontend, responsive bootstrap 5 dashboard, material design, material dashboard bootstrap 5 dashboard">
    <meta name="description"
        content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you.">

    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@creativetim">
    <meta name="twitter:title" content="Material Dashboard PRO by Creative Tim">
    <meta name="twitter:description"
        content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you.">
    <meta name="twitter:creator" content="@creativetim">
    <meta name="twitter:image"
        content="https://s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_bs5_thumbnail.jpg">

    <meta property="fb:app_id" content="655968634437471">
    <meta property="og:title" content="Material Dashboard PRO by Creative Tim" />
    <meta property="og:type" content="article" />
    <meta property="og:url"
        content="https://demos.creative-tim.com/material-dashboard-pro/pages/dashboards/default.html" />
    <meta property="og:image"
        content="https://s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_bs5_thumbnail.jpg" />
    <meta property="og:description"
        content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you." />
    <meta property="og:site_name" content="Creative Tim" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link id="pagestyle" href="{{ asset('material-dashboard/assets/css/material-dashboard.min.css?v=3.0.6') }}"
        rel="stylesheet" />
</head>

<body class>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>

    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">

                <nav
                    class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid ps-2 pe-0">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="{{ route('dashboard') }}">
                            SISTEMA VETERINARIA SAN MARTÍN
                        </a>
                        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon mt-2">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </span>
                        </button>

                    </div>
                </nav>

            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                                style="background-image: url('{{ asset('assets/images/login-logo.png') }}'); background-size: cover;">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                            <div class="card card-plain"
                                style="border: 2px solid #e91e63;
                                box-shadow: 0 14px 26px -12px rgba(233, 30, 99, 0.4), 0 4px 23px 0 rgba(233, 30, 99, 0.15), 0 8px 10px -5px rgba(233, 30, 99, 0.2);
}
                            ">
                                <div class="card-header">
                                    <h4 class="font-weight-bolder text-center">Iniciar Sesión</h4>
                                    <p class="mb-0">Ingresa tu correo electrónico y contraseña para iniciar sesión</p>
                                </div>
                                <div class="card-body">
                                    <p class="text-danger">{{ $errors->first('email') ? $errors->first('email') : '' }}
                                    </p>
                                    <p class="text-danger">
                                        {{ $errors->first('password') ? $errors->first('password') : '' }}</p>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        {{-- <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">usuario</label>
                                            <input type="text" class="form-control">
                                        </div> --}}
                                        <div
                                            class="input-group input-group-outline mb-3 {{ $errors->first('email') || $errors->first('captcha') ? 'is-filled' : '' }}">
                                            <label class="form-label">Correo electrónico</label>
                                            <input type="email" class="form-control" name="email" required
                                                value="{{ old('email') }}">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input type="password" name="password" required
                                                autocomplete="current-password" class="form-control">
                                        </div>
                                        {{-- <div class="form-check form-check-info text-start ps-0">
                                            <input class="form-check-input" type="checkbox" value
                                                id="flexCheckDefault" checked>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                I agree the <a href="javascript:;"
                                                    class="text-dark font-weight-bolder">Terms and Conditions</a>
                                            </label>
                                        </div> --}}
                                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}">
                                        </div>
                                        <p id="captcha-error" class="text-danger">
                                            {{ $errors->first('captcha') ? $errors->first('captcha') : '' }}
                                        </p>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Ingresar</button>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-2 text-sm mx-auto">
                                        Already have an account?
                                        <a href="../../../pages/authentication/signin/basic.html"
                                            class="text-primary text-gradient font-weight-bold">Sign in</a>
                                    </p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('material-dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <script src="{{ asset('material-dashboard/assets/js/plugins/dragula/dragula.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/jkanban/jkanban.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.getElementById('captcha-error').innerText = ''
            }, 3500);
        });
    </script>


    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="{{ asset('material-dashboard/assets/js/material-dashboard.min.js?v=3.0.6') }}"></script>
</body>

</html>
