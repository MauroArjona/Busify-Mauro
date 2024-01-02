@extends('layouts.principal')
@section('title', 'Detalle del pasajero')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container" style="height: 100%;">
                <div class="block-heading" style="margin: -19px;padding: 65px 0px 0px;">
                    <h2 class="text-info">Detalles de pasajero</h2>
                    <p>Aquí podrá encontrar todos los datos correspondientes al pasajero.</p>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user" action="{{ route('home') }}"><label
                                    class="form-label fs-4 text-primary">Pasajero</label>
                                <hr><label class="form-label"><strong>Nombre:</strong></label>
                                <div title="{{ $passenger->passenger_name }}" class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input value="{{ $passenger->passenger_name }}"
                                            class="form-control form-control-user" type="text" id="nombre-id-7"
                                            required="true" name="horario-vuelta" readonly="" disabled=""></div>
                                </div><label class="form-label"><strong>Apellido:</strong></label>
                                <div title="{{ $passenger->passenger_last_name }}" class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input value="{{ $passenger->passenger_last_name }}"
                                            class="form-control form-control-user" type="text" id="nombre-id-2"
                                            required="true" name="horario-vuelta" readonly="" disabled=""></div>
                                </div><label class="form-label"><strong>DNI:</strong></label>
                                <div title="{{ $passenger->passenger_dni }}" class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input value="{{ $passenger->passenger_dni }}"
                                            class="form-control form-control-user" type="text" id="nombre-id-1"
                                            required="true" name="horario-vuelta" readonly="" disabled=""></div>
                                </div><label class="form-label"><strong>Grupo sanguineo:</strong></label>
                                <div title="{{ $passenger->blood_type }}" class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input value="{{ $passenger->blood_type }}"
                                            class="form-control form-control-user" type="text" id="nombre-id-9"
                                            required="true" name="horario-vuelta" readonly="" disabled=""></div>
                                </div><label class="form-label"><strong>Discapacidad:</strong></label>
                                <div title="{{ $passenger->disability }}" class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input value="{{ $passenger->disability }}"
                                            class="form-control form-control-user" type="text" id="nombre-id-3"
                                            required="true" name="horario-vuelta" readonly="" disabled=""></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
