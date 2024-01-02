@extends('layouts.principal')
@section('title', 'Cargar unidad')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container" style="height: 100%;">
                <div class="block-heading">
                    <h2 class="text-info">Cargar unidad</h2>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user" action="{{ route('unit.store') }}" method="POST" class="save-record"
                                onsubmit="saveUnit(event,this);">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control form-control-user" type="text" placeholder="Patente"
                                            name="unit_patent" id="patent">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="number"
                                            placeholder="Capacidad total" name="unit_total_capacity" id="total_capacity" min="1" max="15">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="text" placeholder="Modelo"
                                            name="unit_model" id="model">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="text" name="unit_brand"
                                            placeholder="Marca" id="brand">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="number"
                                            placeholder="Kilometraje"  name="unit_mileage" id="unit_mileage">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <p id="emailErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                    <p id="passwordErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" id="crear-cuenta-btn-id"
                                    type="submit">Cargar unidad</button>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        limitarLongitudCampo('#total_capacity', 2);
        function limitarLongitudCampo(selector, longitudMaxima) {
            $(selector).on('input', function() {
                if ($(this).val().length > longitudMaxima) {
                    $(this).val($(this).val().slice(0, longitudMaxima));
                }
            });
        }
    </script>
@endsection
