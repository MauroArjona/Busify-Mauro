@extends('layouts.principal')
@section('title', 'Detalles supervisor')
@section('content')
<main class="page registration-page" style="height: 100%;">
    <section class="clean-block clean-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Detalles del supervisor</h2>
                <p>Aquí podrá encontrar todos los datos correspondientes a un supervisor.</p>
            </div>
            <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center" style="/*--bs-body-bg: #fff;*/">
                <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7" style="/*border-radius: 5px;*//*border-style: none;*/">
                    <div class="p-5">
                        <form class="user">
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="col-form-label" for="name">Nombre:</label>
                                    <input class="form-control form-control-user" type="text" placeholder="Nombre" name="name" value="{{ $supervisor->user->name }}" title="{{ $supervisor->user->name }}" disabled>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label" for="lastName">Apellido:</label>
                                    <input class="form-control form-control-user" type="text" placeholder="Apellido" name="lastName" value="{{ $supervisor->user->lastName }}" title="{{ $supervisor->user->lastName }}" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label class="col-form-label" for="dni">DNI:</label>
                                    <input class="form-control form-control-user" type="number" id="dni-id" placeholder="DNI" name="dni" value="{{ $supervisor->user->dni }}" title="{{ $supervisor->user->dni }}" disabled>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label" for="phoneNumber">Teléfono:</label>
                                    <input class="form-control form-control-user" type="text" placeholder="Teléfono" name="phoneNumber" value="{{ $supervisor->user->phoneNumber }}" title="{{ $supervisor->user->phoneNumber }}" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="email">Email:</label>
                                <input class="form-control form-control-user assistant-hide" type="email" id="email-id" name="email" value="{{ $supervisor->user->email }}" title="{{ $supervisor->user->email }}" disabled>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="col-form-label" for="birthdate">Fecha de nacimiento:</label>
                                    <input class="form-control form-control-user assistant-hide" type="date" name="birthdate" value="{{ $supervisor->user->birthdate }}" title="{{ $supervisor->user->birthdate }}" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label" for="address">Domicilio:</label>
                                <input class="form-control form-control-user assistant-hide" type="text" name="address" value="{{ $supervisor->user->address }}" title="{{ $supervisor->user->address }}" disabled>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection