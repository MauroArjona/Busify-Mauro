@extends('layouts.principal')
@section('title', 'Inicio')
@section('content')
    <main class="page landing-page">
        <section class="clean-block clean-info dark">
            <div class="container">
                <div class="block-heading">
                    <section class="d-xxl-flex py-4 py-xl-5" style="margin-top: -46px;">
                        <div class="container">
                            <div class="bg-dark border rounded border-0 border-dark overflow-hidden">
                                <div class="row g-0">
                                    <div class="col-md-6">
                                        @if (Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    @if (Session::has('error'))
                                    <div class="alert alert-danger">
                                        {{ Session::get('error') }}
                                    </div>
                                @endif
                                        <div class="text-white p-4 p-md-5">
                                            <h2 class="fw-bold text-white mb-3">Una nueva forma de llegar a la escuela
                                            </h2>
                                            <p class="mb-4">Ofrecemos un servicio de transporte escolar seguro y
                                                confiable para que tus hijos lleguen a la escuela sanos y salvos.</p>
                                            @auth
                                                <div class="my-3"><a class="btn btn-primary btn-lg me-2" role="button"
                                                        href="{{ route('user.index') }}">Ver perfil</a></div>
                                            @endauth
                                            @guest
                                                <div class="my-3"><a class="btn btn-primary btn-lg me-2" role="button"
                                                        href="{{ route('register') }}">¡Registrate!</a></div>
                                            @endguest
                                        </div>
                                    </div>
                                    <div class="col-md-6 order-first order-md-last" style="min-height: 250px;"><img
                                            class="w-100 h-100 fit-cover" src="import/assets/img/home/school-bus.webp">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h2 class="text-info">Tus hijos seguros en el camino a la escuela</h2>
                    <p>Estamos comprometidos a brindar un servicio de calidad que supere tus expectativas</p>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6"><img class="img-thumbnail" src="import/assets/img/home/bus-stop-home.webp">
                    </div>
                    <div class="col-md-6">
                        <h3>Servicios diseñados para tu comodidad</h3>
                        <div class="getting-started-info">
                            <p>Nuestro objetivo es brindarle a tus hijos la mayor seguridad y
                                comodidad de camino a la escuela. ¡Puedes conocerlos aquí!</p>
                        </div><a class="btn btn-outline-primary btn-lg" role="button"
                            href="{{ route('services.index') }}">Servicios</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
