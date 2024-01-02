<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('import/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('import/assets/css/baguetteBox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('import/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('import/assets/css/Banner-Heading-Image-images.css') }}">
    <link rel="stylesheet" href="{{ asset('import/assets/css/Pretty-Registration-Form-.css') }}">
    <link rel="stylesheet" href="{{ asset('import/assets/css/vanilla-zoom.min.css') }}">
    <link rel="icon" href="{{ asset('import/assets/icon/iconBusify.jpeg') }}" type="image/x-icon" />

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    @yield('styles')
</head>

<body style="background: rgb(248,249,250);">
    <nav class="navbar navbar-expand-xl fixed-top bg-warning-subtle clean-navbar navbar-light" style="font-family:Montserrat, sans-serif;">
        <div class="container-fluid"><a class="navbar-brand logo" href="{{ route('home') }}"><strong>Busify</strong></a><button data-bs-toggle="collapse" data-bs-target="#navcol-1" class="navbar-toggler"><span class="visually-hidden">Toggle
                    navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/*') ? 'active' : '' }}" href="{{ route('home') }}">INICIO</a></li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">SERVICIOS</a>
                        <div class="dropdown-menu">
                            @can('service.list-services')
                            <a class="dropdown-item" href="{{ route('service.list-services') }}">Lista de servicios</a>
                            @endcan
                            <a class="dropdown-item" href="{{ route('services.index') }}">Servicios disponibles</a>
                            <a class="dropdown-item" href="{{ route('service.service-price-simulator') }}">Simular
                                tarifa</a>
                        </div>
                    </li>

                    @can('itinerary.index')
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">ITINERARIO</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('itinerary.index') }}">Lista de itinerarios</a>
                            <a class="dropdown-item" href="{{ route('itinerary.create') }}">Crear itinerario</a>
                        </div>
                    </li>
                    @endcan

                    @can('driver.index')
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">RECURSOS</a>
                        <div class="dropdown-menu">
                            @can('unit.index')
                            <a class="dropdown-item" href="{{ route('price.index') }}">Precios</a>
                            <a class="dropdown-item" href="{{ route('unit.index') }}">Unidades</a>
                            @endcan
                            <a class="dropdown-item" href="{{ route('driver.index') }}">Choferes</a>
                            <a class="dropdown-item" href="{{ route('assistants.index') }}">Asistentes</a>
                            @can('supervisor.index')
                            <a class="dropdown-item" href="{{ route('supervisor.index') }}">Supervisores</a>
                            @endcan
                        </div>
                    </li>
                    @endcan

                    @can('contract.index')
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">CONTRATOS</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('contract.index') }}">Todos</a>
                            <a class="dropdown-item" href="{{ route('contract.waitingApproval') }}">Esperando
                                aprobación</a>
                            <a class="dropdown-item" href="{{ route('contract.enabled') }}">Habilitados</a>
                        </div>
                    </li>
                    @endcan
                    @can('reports.all')
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">REPORTES</a>
                        <div class="dropdown-menu">
                            <a target="_blank" class="dropdown-item" href="{{ route('report-clients') }}">Clientes</a>
                            <a target="_blank" class="dropdown-item" href="{{ route('report-units') }}">Unidades</a>
                            <a target="_blank" class="dropdown-item" href="{{ route('report-incomes') }}">Ingresos</a>
                        </div>
                    </li>
                    @endcan

                    @can('client.index')
                    <li class="nav-item"><a class="nav-link {{ request()->is('client*') ? 'active' : '' }}" href="{{ route('client.index') }}">Clientes</a></li>
                    @endcan

                    @can('payment.index')
                    <li class="nav-item"><a class="nav-link {{ request()->is('payment*') ? 'active' : '' }}" href="{{ route('payment.index') }}">Mis pagos</a></li>
                    @endcan

                    @can('fee.index')
                    <li class="nav-item"><a class="nav-link {{ request()->is('fee*') ? 'active' : '' }}" href="{{ route('fee.index') }}">Cuotas</a></li>
                    @endcan
                    @can('contract.showContractClient')
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">CONTRATO</a>
                        <div class="dropdown-menu">
                            @if (auth()->user()->userable->contracts->where('contract_state', 'HABILITADO')->count() == 0 &&
                            auth()->user()->userable->contracts->where('contract_state', 'ESPERANDO_APROBACION')->count() == 0
                            &&
                            auth()->user()->userable->contracts->where('contract_state', 'FINALIZADO_CON_DEUDA')->count() == 0)

                            <a class="nav-link" href="{{ route('contract.create') }}">Nuevo contrato</a>
                            @endif
                            <a class="nav-link {{ request()->is('contract.contractClient') ? 'active' : '' }}" href="{{ route('contract.contractClient') }}">Mi contrato</a>
                            <a class="nav-link" href="{{ route('contract.historial') }}">Historial</a>
                        </div>
                    </li>
                    @endcan
                    @can('driver.showTravelPlan')
                    <li class="nav-item"><a class="nav-link {{ request()->is('driver*') ? 'active' : '' }}" href="{{ route('driver.showTravelPlan') }}">Mi itinerario</a></li>
                    @endcan
                    @can('driver.showTravelPlan')
                    <li class="nav-item"><a class="nav-link {{ request()->is('travel-report*') ? 'active' : '' }}" href="{{ route('travel-report.driverTravelReport') }}">Mis partes de viajes</a></li>
                    @endcan

                    @can('travel-report.index')
                    <li class="nav-item"><a class="nav-link {{ request()->is('travel-report.index') ? 'active' : '' }}" href="{{ route('travel-report.index') }}">Partes de viajes</a></li>
                    @endcan

                </ul>
                <div class="theme-switcher dropdown"><a class="dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-sun-fill mb-1">
                            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                            </path>
                        </svg></a>
                    <div class="dropdown-menu"><a class="dropdown-item d-flex align-items-center" href="#" data-bs-theme-value="light"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-sun-fill opacity-50 me-2">
                                <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                                </path>
                            </svg>Light</a><a class="dropdown-item d-flex align-items-center" href="#" data-bs-theme-value="dark"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-moon-stars-fill opacity-50 me-2">
                                <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z">
                                </path>
                                <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z">
                                </path>
                            </svg>Dark</a><a class="dropdown-item d-flex align-items-center" href="#" data-bs-theme-value="auto"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-circle-half opacity-50 me-2">
                                <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"></path>
                            </svg>Auto</a></div>
                </div>
                @guest
                <a href="{{ route('register') }}" style="text-decoration: none;text-transform: uppercase;font-weight: 600;color: var(--bs-navbar-color);font-size: 12.8px;margin-right: 32px;margin-left: 32px;">Registrarse</a>
                <a href="{{ route('login') }}" style="background: rgb(13, 110, 253);border-radius: 6px;color: rgb(255,255,255);padding: 8px;border-width: 1px;text-transform: uppercase;border-color: rgb(255,255,255);text-decoration: none;font-size: 12.8px;font-weight: 600;margin-right: .5em;">Iniciar
                    sesión</a>
                @endguest
                @can('contract.create')
                <a style="text-decoration: none; text-transform: uppercase; font-weight: 600; color: var(--bs-navbar-color); font-size: 12.8px; margin-right: 32px; margin-left: 32px;">
                    @if (auth()->user()->userable->contracts->where('client_id', auth()->user()->userable->id)->isNotEmpty())
                    Puntos:
                    {{ optional(
                                auth()->user()->userable->contracts->where('client_id', auth()->user()->userable->id)->first(),
                            )
                                ? optional(
                                    auth()->user()->userable->contracts->where('client_id', auth()->user()->userable->id)->first()->currentAccount,
                                )->current_account_score
                                : 'Sin contrato' }}
                    @endif
                </a>


                @endcan


                @auth

                <a href="{{ route('user.index') }}" style="text-decoration: none;text-transform: uppercase;font-weight: 600;color: var(--bs-navbar-color);font-size: 12.8px;margin-right: 32px;margin-left: 32px;">Mi
                    perfil</a>

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" style="background: rgb(13, 110, 253);border-radius: 6px;color: rgb(255,255,255);padding: 8px;border-width: 1px;text-transform: uppercase;border-color: rgb(255,255,255);text-decoration: none;font-size: 12.8px;font-weight: 600;margin-right: .5em;">Cerrar
                        sesión</button>
                </form>
                @endauth
            </div>
        </div>
    </nav>
    @yield('content')
    <script src="{{ asset('import/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('import/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('import/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('import/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('import/assets/js/theme.js') }}"></script>
    <script src="{{ asset('import/assets/js/themeSwitcher.js') }}"></script>

</body>

</html>