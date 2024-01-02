@extends('layouts.principal')
@section('title', 'Detalles cliente')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Detalles del cliente</h2>
                    <p>Aquí podrá encontrar todos los datos correspondientes al cliente.</p>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user">
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="col-form-label" for="name">Nombre:</label>
                                        <input class="form-control form-control-user" type="text" 
                                        name="name" value="{{ $client->user->name }}" title="{{ $client->user->name }}" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="lastName">Apellido:</label>
                                        <input class="form-control form-control-user" type="text"
                                         name="lastName" value="{{ $client->user->lastName }}" title="{{ $client->user->lastName }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="cuil">CUIL:</label>
                                        <input class="form-control form-control-user" type="number"
                                            id="cuil-id" name="dni" value="{{ $client->client_cuil }}" title="{{ $client->client_cuil }}" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="phoneNumber">Teléfono:</label>
                                        <input class="form-control form-control-user" type="text"
                                         name="phoneNumber" value="{{ $client->user->phoneNumber }}" title="{{ $client->user->phoneNumber }}"disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="email">Email:</label>
                                        <input class="form-control form-control-user assistant-hide" type="email"
                                        id="email-id" name="email" value="{{ $client->user->email }}" title="{{ $client->user->email }}"disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="birthdate">Fecha de nacimiento:</label>
                                        <input class="form-control form-control-user assistant-hide" type="date"
                                        name="birthdate" value="{{ $client->user->birthdate }}" title="{{ $client->user->birthdate }}"disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label class="col-form-label" for="address">Domicilio:</label>
                                        <input class="form-control form-control-user assistant-hide" type="text"
                                             name="address" value="{{ $client->user->address }}" title="{{ $client->user->address }}"disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
