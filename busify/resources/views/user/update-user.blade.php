@extends('layouts.principal')
@section('title', 'Perfil')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Modificar cuenta</h2>
                    <p>Modifique los datos que necesite de su cuenta.</p>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user" action="{{ route('user.update', $client->id) }}" method="POST"
                                onsubmit="validarFormulario(event, this);">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                        <label for="">Teléfono</label>
                                        <input class="form-control form-control-user" type="tel" id="phoneNumber-id"
                                            placeholder="Teléfono" name="phoneNumber" value="{{ $client->user->phoneNumber }}">
                                    </div>

                                <div class="mb-3">
                                    <label for="">Dirección</label>
                                    <input class="form-control form-control-user" type="text" id="address-id"
                                        placeholder="Dirección" name="address" value="{{ $client->user->address }}">
                                </div>

                                <div class="row mb-3">
                                    <p id="emailErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                    <p id="passwordErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                </div><button class="btn btn-primary d-block btn-user w-100" id="crear-cuenta-btn-id"
                                    type="submit">Guardar cambios</button>
                                <hr>
                            </form>
                            <div class="text-center"></div>
                            <div class="text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    </body>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        limitarLongitudCampo('#phoneNumber-id', 15);
         function limitarLongitudCampo(selector, longitudMaxima) {
             $(selector).on('input', function() {
                 if ($(this).val().length > longitudMaxima) {
                     $(this).val($(this).val().slice(0, longitudMaxima));
                 }
             });
         }
    </script>
@endsection
