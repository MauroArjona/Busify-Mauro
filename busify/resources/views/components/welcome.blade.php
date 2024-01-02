<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Busify</title>
    <link rel="stylesheet" href="{{ asset('import/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('import/assets/css/baguetteBox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('import/assets/css/Banner-Heading-Image-images.css') }}">
    <link rel="stylesheet" href="{{ asset('import/assets/css/Pretty-Registration-Form-.css') }}">
    <link rel="stylesheet" href="{{ asset('import/assets/css/vanilla-zoom.min.css') }}">
</head>

<body>
    <main class="page landing-page">
        <section class="clean-block clean-info dark">
            <div class="container">
                <div class="block-heading">
                    <section class="d-xxl-flex py-4 py-xl-5" style="margin-top: -46px;">
                        <div class="container">
                            <div class="bg-dark border rounded border-0 border-dark overflow-hidden">
                                <div class="row g-0">
                                    <div class="col-md-6">
                                        <div class="text-white p-4 p-md-5">
                                            <h2 class="fw-bold text-white mb-3">Una nueva forma de llegar a la escuela
                                            </h2>
                                            <p class="mb-4">Ofrecemos un servicio de transporte escolar seguro y
                                                confiable para que tus hijos lleguen a la escuela sanos y salvos.</p>
                                            @auth
                                                <div class="my-3"><a class="btn btn-primary btn-lg me-2" role="button"
                                                        href="{{ route('profile.show') }}">Ver perfil</a></div>
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
                            <p>Nuestros servicios están diseñados para brindarle a tus hijos la mayor seguridad y
                                comodidad de camino a la escuela. Puedes conocerlos y conocer precios!.</p>
                        </div><a class="btn btn-outline-primary btn-lg" role="button"
                            href="{{route('services.index')}}">Servicios</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
