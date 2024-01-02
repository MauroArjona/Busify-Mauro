@extends('layouts.principal')
@section('title', 'Detalle del servicio')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container" style="height: 100%;">
                <div class="block-heading" style="margin: -19px;padding: 65px 0px 0px;">
                    <h2 class="text-info">Detalles de servicio</h2>
                    <p>Aquí podrá encontrar todos los datos correspondientes a un servicio.</p>
                </div>
                <br><br>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-11"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="container d-xl-flex gap-5 bg-white p-5 rounded">
                            {{-- Datos del Servicio --}}
                            <div>
                                <p class="fs-4 text-primary">Servicio {{ $service->id }}</p>
                                <hr>
                                <p><strong>Nro. de servicio: </strong>{{ $service->id . ' ' }} </p>

                                <p><strong>Tipo de servicio:
                                    </strong>{{ str_replace('eSrv', 'o', class_basename($service->service_type)) }}</p>

                                <p><strong>Distancia: </strong> {{ $service->distance }}</p>

                                <p><strong>Dirección de ida: </strong> {{ $service->origin_going }}</p>

                                <p><strong>Dirección de vuelta: </strong> {{ $service->destination_going }}</p>

                                <p><strong>Horario de retiro: </strong> {{ $service->hour_pickup_going }}</p>

                                <p><strong>Horario de ingreso:</strong> {{ $service->hour_arrival_going }}</p>

                                @if ($service->service_type == 'App\Models\CompleteSrv')
                                    <p><strong>Horario de vuelta: </strong> {{ $service->hour_arrival_return }}</p>
                                @endif
                            </div>

                            <div>
                                @foreach ($passengers as $passenger)
                                    <p class="fs-4 text-primary">Datos del pasajero</p>
                                    <hr>
                                    <p><strong>Nombre y apellido:</strong>
                                        {{ $passenger->passenger_name . ' ' . $passenger->passenger_last_name }}</p>
                                    <p><strong>DNI: </strong> {{ $passenger->passenger_dni }}</p>
                                    <p><strong>Grupo sanguineo:</strong> {{ $passenger->blood_type }}</p>
                                @endforeach
                            </div>
                            <hr>

                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
