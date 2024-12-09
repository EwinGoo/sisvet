@php
    $usuario = $data['usuario'];
@endphp
<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo" />
            <span class="ms-1 font-weight-bold text-white">{{ $sistema }}</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2" />
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav"
                    role="button" aria-expanded="false">
                    <img src="{{ $usuario->image }}" class="avatar" />
                    <div>
                        <span class="nav-link-text ms-2 ps-1">
                            {{ $usuario->nombre . ' ' . $usuario->paterno }}
                        </span>
                        <div class="text-center" style="margin-left: 0.4rem;">
                            <span class="text-center badge bg-gradient-success">{{ $usuario->rol }}</span>
                        </div>
                    </div>
                </a>
                <div class="collapse" id="ProfileNav" style>
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../../pages/pages/profile/overview.html">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal ms-3 ps-1">Perfil</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link text-white" href="../../pages/pages/account/settings.html">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal ms-3 ps-1"> Settings </span>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="post" style="margin: 0 16px">
                                @csrf
                                <button type="submit" class="btn btn-primary nav-link text-white">
                                    <span class="sidenav-mini-icon"> CS </span>
                                    <span class="sidenav-normal ms-3 ps-1"> Cerrar Sesión </span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
            <hr class="horizontal light mt-0" />
            @php
                $count = 0;
            @endphp
            @foreach ($menu as $mKey => $mVal)
                <li class="nav-item">
                    @if ($mVal == '<hr>')
                        <hr class="horizontal light mt-0" />
                    @elseif (gettype($mKey) == 'integer')
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder text-white mt-1">
                            {{ $mVal }}
                        </h6>
                    @elseif (gettype($mVal) == 'string')
                        @php
                            $mValue = strpos($mVal, 'admin') !== false ? $mVal . '.index' : $mVal;
                        @endphp
                        <a class="nav-link {{ $mVal == $page ? 'active' : '' }}" href="{{ route("$mValue") }}">
                            <i
                                class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">{{ isset($icon[$mKey]) ? $icon[$mKey] : '' }}</i>
                            <span class="nav-link-text ms-2 ps-1 text-capitalize">{{ $mKey }}</span>
                        </a>
                    @elseif(gettype($mVal) == 'array')
                        @php
                            $count++;
                            $option = in_array($page, $mVal);
                        @endphp
                        <a data-bs-toggle="collapse" href="#menu{{ $count }}"
                            class="nav-link text-white {{ $option ? 'active' : '' }}"
                            aria-controls="menu{{ $count }}" role="button" aria-expanded="false">

                            <i
                                class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">{{ isset($icon[$mKey]) ? $icon[$mKey] : '' }}</i>
                            <span class="nav-link-text ms-2 ps-1 text-capitalize">{{ $mKey }}</span>
                        </a>
                        <div class="collapse {{ $option ? 'show' : '' }}" id="menu{{ $count }}">
                            <ul class="nav">
                                @foreach ($mVal as $smKey => $smVal)
                                    @php
                                        $smValue = strpos($smVal, 'admin') !== false ? $smVal . '.index' : $smVal;
                                    @endphp
                                    <li class="nav-item {{ $smVal == $page ? 'active' : '' }}">
                                        <a class="nav-link text-white {{ $smVal == $page ? 'active' : '' }}"
                                            href="{{ route($smValue) }}">
                                            <span class="sidenav-mini-icon text-capitalize">
                                                {{ mb_substr($smKey, 0, 1, 'UTF-8') }} </span>
                                            <span class="sidenav-normal ms-2 ps-1 text-capitalize">{{ $smKey }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
            {{-- <li class="nav-item">
                <a class="nav-link"
                    href="https://github.com/creativetimofficial/ct-material-dashboard-pro/blob/master/CHANGELOG.md"
                    target="_blank">
                    <i
                        class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">receipt_long</i>
                    <span class="nav-link-text ms-2 ps-1">Changelog</span>
                </a>
            </li> --}}
        </ul>
    </div>
</aside>
