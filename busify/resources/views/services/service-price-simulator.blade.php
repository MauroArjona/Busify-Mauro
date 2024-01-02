@extends('layouts.principal')
{{-- @can('itinerary.allocate-resources') acceso unicamente por el usuario con rol de supervisor --}}
@section('title', 'Simular tarifa')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Simular tarifa</h2>
                    <p style="max-width: fit-content;">En caso de tener más de 1 pasajero, se aplicará un descuento del
                        <strong>{{ $priceServiceSemi->discount_per_aditional_passenger }}% </strong>para el servicio
                        semicompleto, en
                        caso del completo es un descuento del
                        <strong>{{ $priceServiceComplete->discount_per_aditional_passenger }}%</strong>.<br>
                        Si hay más de 1 tipo de servicio, se aplicará el descuento del servicio con <strong>mayor cantidad
                            de pasajeros</strong>.
                        Y si hay más de 1 tipo de servicio con la misma cantidad de pasajeros, se aplicará el descuento del
                        servicio con <strong>mayor distancia</strong>.<br>
                        Todo descuento es aplicado sobre el precio total.
                    </p>
                </div>
                <form method="POST" action="{{ route('service.calculate-price') }}"onsubmit="validarFormulario(event, this);">
                    @csrf
                    <div style="display: flex;justify-content: space-between;">
                        <h3 style="margin-bottom: 1em;">Completo</h3>
                        <h3 style="margin-bottom: 1em;">Semicompleto</h3>
                    </div>
                    <div style="display: flex;">
                        <div class="mb-3" style="margin-right: 4em;">
                            <label class="form-label"><i class="fas fa-user" style="margin-right: 0.5em;"></i>Cantidad
                                pasajeros</label>
                            <input class="form-control" type="number" placeholder="Completo"
                                name="passengerComplete">
                        </div>
                        <div><label class="form-label"><i class="fas fa-user" style="margin-right: 0.5em;"></i>Cantidad
                                pasajeros</label>
                            <div data-bs-toggle="tooltip" data-bss-tooltip="" class="row mb-3" title="das">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;">
                                    <input class="form-control form-control-user" type="number" name="passengerSemi"
                                        style="width: 100%;" placeholder="Semicompleto">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex;">
                        <div class="mb-3" style="margin-right: 4em;">
                            <label class="form-label">
                                <i class="fas fa-bus" style="margin-right: 0.5em;"></i>Distancia en km.
                            </label>
                            <input class="form-control" type="text" placeholder="Completo" name="distanceComplete" pattern="[0-9]+([.][0-9]+)?"  oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                        </div>
                        <div>
                            <label class="form-label">
                                <i class="fas fa-bus" style="margin-right: 0.5em;"></i>Distancia en km.
                            </label>
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;">
                                    <input class="form-control form-control-user" type="text" name="distanceSemi" style="width: 100%;" placeholder="Semicompleto" pattern="[0-9]+([.][0-9]+)?" oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (isset($totalPrice))
                        <div class="alert alert-success">
                            El precio total es: ${{number_format($totalPrice), 2 , ',', '.'}}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="d-flex flex-row justify-content-between justify-content-xl-center" style="margin-top: 2em;">
                        <button class="btn btn-success d-xl-flex mx-auto" type="submit">Calcular</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/service-price-simulator.js') }}"></script>
@endsection
