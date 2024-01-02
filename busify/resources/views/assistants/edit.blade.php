@extends('layouts.principal')
@section('title', 'Modificar asistente')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container" style="height: 100%;">
                <div class="block-heading">
                    <h2 class="text-info">Modificar asistente</h2>
                </div>
                <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center"
                    style="/*--bs-body-bg: #fff;*/">
                    <div class="col-sm-12 col-lg-10 col-xl-9 col-xxl-7"
                        style="/*border-radius: 5px;*//*border-style: none;*/">
                        <div class="p-5">
                            <form class="user" action="{{ route('assistants.update', $assistant->id) }}" method="POST" onsubmit="editAssistant(event,this);"
                                class="save-record">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0" title="{{ $assistant->assistant_name }}">
                                        <strong>Nombre:</strong>
                                        <input class="form-control form-control-user"
                                            type="text" id="nombre-id-1" placeholder="Nombre" required="true"
                                            name="name" value="{{ $assistant->assistant_name }}">
                                        </div>
                                    <div class="col-sm-6" title="{{ $assistant->assistant_last_name }}">
                                        <strong>Apellido:</strong>
                                        <input class="form-control form-control-user" type="text" id="apellido-id-1"
                                            placeholder="Apellido" required="true" name="lastName" value="{{ $assistant->assistant_last_name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <strong>CUIL:</strong>
                                        <input class="form-control form-control-user" type="number" id="cuil-id"
                                            placeholder="CUIL" required="true" name="cuil" value="{{ $assistant->assistant_cuil }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Estado:</strong>
                                        <input class="form-control form-control-user" type="text" id="cuil-id-1"
                                            required="true" name="state" disabled="" readonly="" value="{{ $assistant->assistant_state }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <p id="emailErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                    <p id="passwordErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" id="crear-cuenta-btn-id"
                                    type="submit">Modificar datos</button>
                                <hr>
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
