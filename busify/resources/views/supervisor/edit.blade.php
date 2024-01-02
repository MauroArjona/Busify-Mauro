@extends('layouts.principal')
@section('title', 'Modificar supervisor')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container" style="height: 100%;">
                <div class="block-heading">
                    <h2 class="text-info">Modificar supervisor</h2>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user" action="{{ route('supervisor.update', $supervisor->id) }}" method="POST" onsubmit="editSupervisor(event,this);"
                                class="save-record">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="col-form-label" for="name">Nombre:</label>
                                        <input class="form-control form-control-user" type="text" placeholder="Nombre" name="name" id="name-id" required="true" value="{{ $supervisor->user->name }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="lastName">Apellido:</label>
                                        <input class="form-control form-control-user" type="text" placeholder="Apellido" name="lastName" id="lastName-id" required="true" value="{{ $supervisor->user->lastName }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="dni">DNI:</label>
                                        <input class="form-control form-control-user" type="number" id="dni-id" placeholder="DNI" name="dni" required="true" value="{{ $supervisor->user->dni }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="phoneNumber">Teléfono:</label>
                                        <input class="form-control form-control-user" type="text" placeholder="Teléfono" name="phoneNumber" id="phoneNumber-id" required="true" value="{{ $supervisor->user->phoneNumber }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="email">Email:</label>
                                        <input class="form-control form-control-user assistant-hide" type="email" id="email-id" name="email" required="true" value="{{ $supervisor->user->email }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label" for="cuil">CUIL:</label>
                                        <input class="form-control form-control-user" type="text" name="cuil" id="cuil-id" required="true" pattern="[0-9]+"  value="{{ $supervisor->supervisor_cuil }}">
                                    </div>    
                                </div>
    
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="col-form-label" for="birthdate">Fecha de nacimiento:</label>
                                        <input class="form-control form-control-user assistant-hide" type="date" name="birthdate" id="birthdate-id" required="true" value="{{ $supervisor->user->birthdate }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label" for="address">Domicilio:</label>
                                    <input class="form-control form-control-user assistant-hide" type="text" name="address" id="address-id" required="true" value="{{ $supervisor->user->address }}">
                                </div>
                                <div class="row mb-3">
                                    <p id="emailErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                    <p id="passwordErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" id="crear-cuenta-btn-id"
                                    type="submit">Modificar datos</button>
                                <hr>
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
                                <x-validation-errors class="mb-4" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/editEmployees.js') }}"></script>
    <script>
        limitarLongitudCampo('#dni-id', 8);
        limitarLongitudCampo('#phoneNumber-id', 15);
        limitarLongitudCampo('#cuil-id', 11);
         function limitarLongitudCampo(selector, longitudMaxima) {
             $(selector).on('input', function() {
                 if ($(this).val().length > longitudMaxima) {
                     $(this).val($(this).val().slice(0, longitudMaxima));
                 }
             });
         }
    </script>
@endsection
