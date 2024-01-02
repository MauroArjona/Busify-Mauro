@extends('layouts.principal')
@section('title', 'Registrar supervisor')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Registrar supervisor</h2>
                    <p>Complete los datos solicitados en cada campo, cree una cuenta nueva para un empleado comience a
                        disfrutar de los servicios ofrecidos por Busify.</p>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user" action="{{ route('supervisor.store') }}" method="POST" onsubmit="createSupervisor(event,this);">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control form-control-user" type="text" placeholder="Nombre"
                                             name="name" id="name-id" value="{{ old('name') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="text" placeholder="Apellido"
                                             name="lastName" id="lastName-id" value="{{ old('lastName') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="number" id="cuil-id"
                                            placeholder="CUIL" name="cuil" value="{{ old('cuil') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="number" placeholder="Teléfono"
                                             name="phoneNumber" id="phoneNumber-id" value="{{ old('phoneNumber') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control form-control-user assistant-hide" type="email"
                                        id="email-id" placeholder="Email" name="email" value="{{ old('email') }}">
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input title="Fecha de nacimiento"
                                            class="form-control form-control-user assistant-hide" type="date"
                                            name="birthdate" id="birthdate-id" max="{{ date('Y-m-d') }}" value="{{ old('birthdate') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user assistant-hide" type="text"
                                            placeholder="Domicilio" name="address" id="address-id" value="{{ old('Domicilio') }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control form-control-user assistant-hide" type="password"
                                             placeholder="Contraseña" name="password" id="password-id">
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user assistant-hide" type="password"
                                             placeholder="Repetir contraseña"
                                            name="password_confirmation" id="password_confirmation-id">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <p id="emailErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                    <p id="passwordErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" id="crear-cuenta-btn-id"
                                    type="submit">Crear cuenta nueva</button>
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
    <script src="{{ asset('js/registrationEmployees.js') }}"></script>
    <script>
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
