@extends('layouts.principal')
@section('title', 'Crear parte de viaje')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container" style="height: 100%;">
                <div class="block-heading" style="margin: -19px;padding: 65px 0px 0px;">
                    <h2 class="text-info">Parte de viaje</h2>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user" style="height: 42em;width: 39em;max-width: none;"
                                action="{{ route('travel-report.store') }}" method="POST"
                                onsubmit="saveTravelReport(event, this);">
                                @csrf
                                <label class="form-label fs-4 text-primary">Itinerario Nro.&nbsp;
                                    {{ $idTravel }}</label>
                                <hr><label class="form-label"><strong>Descripción:</strong></label>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;">
                                        <textarea class="form-control" style="height: 13em;max-height: 13em;" id="description" name="description"></textarea>
                                    </div>
                                </div>
                                <hr><label class="form-label"><strong>Km de unidad al iniciar:</strong></label>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control" type="number" placeholder="km" id="mileage_start"
                                            name="mileage_start">
                                    </div>
                                </div>
                                <hr><label class="form-label"><strong>Km de unidad al finalizar:</strong></label>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control" type="number" placeholder="km" id="mileage_end"
                                            name="mileage_end">
                                    </div>
                                </div>
                                <div class="text-center justify-content-center" style="display: flex;"><button
                                        id="crear-cuenta-btn-id" class="btn btn-success d-block" type="submit"
                                        style="height: 3em;">Crear</button></div>
                            </form>
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
