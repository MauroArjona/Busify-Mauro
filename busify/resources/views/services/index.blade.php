@extends('layouts.principal')
@section('title', 'Servicios')
@section('content')
    <main class="page pricing-table-page" style="height: 100%;">
        <section class="clean-block clean-pricing dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Tipos de servicios</h2>
                    <p>Busify ofrece dos tipos de servicios adaptándose a tus necesidades.</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-5 col-lg-4">
                        <div class="clean-pricing-item">
                            <div class="heading">
                                <h3>Semicompleto</h3>
                            </div>
                            <p>Servicio que incluye viaje de ida al establecimiento escolar.</p>
                            <div class="features">
                                <h4><span class="feature">Viaje de vuelta:&nbsp;</span><span>No</span></h4>
                                <h4><span class="feature">Destino flexible:&nbsp;</span><span>No</span></h4>
                                <h4><span class="feature">Ahorro de costos:&nbsp;</span><span>Sí</span></h4>
                            </div>
                            <button id="semicompleto-btn" class="btn btn-outline-primary d-block w-100">Simular
                                tarifa</button>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4">
                        <div class="clean-pricing-item">
                            <div class="ribbon"><span>Recomendado</span></div>
                            <div class="heading">
                                <h3>Completo</h3>
                            </div>
                            <p>Servicio que incluye viaje de ida al establecimiento escolar y de vuelta.</p>
                            <div class="features">
                                <h4><span class="feature">Viaje de vuelta:&nbsp;</span><span>Sí</span></h4>
                                <h4><span class="feature">Destino flexible:&nbsp;</span><span>Sí</span></h4>
                                <h4><span class="feature">Comodidad adicional:&nbsp;</span><span>Sí</span></h4>
                            </div>
                            <button id="completo-btn" class="btn btn-outline-primary d-block w-100">Simular tarifa</button>
                        </div>
                    </div>
                    <script>
                        // Evento de click boton semicompleto
                        document
                            .getElementById("semicompleto-btn")
                            .addEventListener("click", function() {
                                const serviceType = "semicompleto";

                                // Setear la cookie con service type
                                document.cookie = `serviceType=${serviceType}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;

                                // Redireccionar
                                window.location.href = "{{ route('service.service-price-simulator') }}";
                            });

                        // Evento de click boton completo
                        document.getElementById("completo-btn").addEventListener("click", function() {
                            const serviceType = "completo";
                            console.log(serviceType);
                            // Setear la cookie con service type
                            document.cookie = `serviceType=${serviceType}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;

                            // Redireccionar
                            window.location.href = "{{ route('service.service-price-simulator') }}";
                        });
                    </script>
                </div>
            </div>
        </section>
    </main>

    {{-- <script src="{{ url('js/serviceType-cookie.js') }}"></script> --}}
@endsection
