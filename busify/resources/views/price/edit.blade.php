@extends('layouts.principal')
@section('title', 'Modificar asistente')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container" style="height: 100%;">
                <div class="block-heading">
                    <h2 class="text-info">Modificar precio</h2>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user" action="{{ route('price.update', $price->id) }}" method="POST"
                                onsubmit="updatePrice(event,this);" class="save-record">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for=""><strong>Tipo de servicio</strong></label>
                                        <input class="form-control form-control-user" type="text" disabled
                                            name="service_type"
                                            value="{{ str_replace('eSrv', 'o', class_basename($price->service_type)) }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for=""><strong>Precio por km</strong></label>
                                        <input class="form-control form-control-user" type="text" placeholder="Precio por km"
                                            required="true" name="price_per_km" value="{{ $price->price_per_km }}" id="price">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for=""><strong>Porcentaje de descuento</strong></label>
                                        <input class="form-control form-control-user" type="text"
                                            name="discount_per_aditional_passenger" placeholder="Descuento %"
                                            value="{{ $price->discount_per_aditional_passenger }}" id="discount">
                                    </div>

                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" id="price-btn-id"
                                    type="submit">Modificar precio</button>
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
@endsection
