@extends('layouts.principal')
@section('title', 'Registrarse')
@section('content')
    <main class="page registration-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Registrarse</h2>
                    <p>Complete los datos solicitados en cada campo, cree una cuenta nueva y comience a disfrutar de los
                        servicios ofrecidos por Busify.</p>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form method="POST" action="{{ route('register') }}" onsubmit="validateRegister(event, this);">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user"
                                            type="text" id="nombre-id" name="name" placeholder="Nombre" value="{{ old('name') }}"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text"
                                            id="lastName-id" name="lastName" placeholder="Apellido" value="{{ old('lastName') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user"
                                            type="tel" id="phoneNumber-id" name="phoneNumber" placeholder="Teléfono" value="{{ old('phoneNumber') }}">
                                    </div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="number"
                                            id="cuil-id" name="cuil" placeholder="CUIL" value="{{ old('cuil') }}"></div>
                                </div>
                                <div class="mb-3"><input class="form-control form-control-user" type="text"
                                        id="address-id" name="address" placeholder="Dirección" value="{{ old('address') }}"></div>
                                <div class="mb-3"><input class="form-control form-control-user" type="email"
                                        id="email-id" name="email" placeholder="Email" value="{{ old('email') }}"></div>
                                <div class="mb-3"><input class="form-control form-control-user" type="date"
                                        id="birthdate-id" name="birthdate" max="{{ date('Y-m-d') }}" value="{{ old('birthdate') }}">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user"
                                            type="password" name="password" id="password-id" placeholder="Contraseña"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="password"
                                            name="password_confirmation" id="password-confirmation-id"
                                            placeholder="Repetir contraseña"></div>
                                </div>
                                <div class="row mb-3">
                                    <p id="emailErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                    <p id="passwordErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                </div><button class="btn btn-primary d-block btn-user w-100" id="crear-cuenta-btn-id"
                                    type="submit">Crear cuenta nueva</button>
                                <hr>
                                 <x-validation-errors class="mb-4" /> 
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
                            </form>

                            <div class="text-center"><a class="small" href="{{ route('login') }}">¿Ya tiene una
                                    cuenta? Inicia sesión!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
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
