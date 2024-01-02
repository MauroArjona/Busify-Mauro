@extends('layouts.principal')
@section('title', 'Crear itinerario')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading" style="width: 84em;margin: auto;">
                    <h2 class="text-info" style="margin-top: 2em">Crear itinerario</h2>
                    <p>Puede agregar o quitar servicios de un nuevo itinerario.</p>

                    <div style="display: flex; margin-top:2.5em;margin-bottom: 2em;align-items: center;">

                        <label class="form-label" style="margin-right: 1em"><strong>Nombre itinerario:</strong></label>
                        <div class="col-sm-6 mb-3 mb-sm-0" style="width: 25em">
                            <input placeholder="Nombre del itinerario" class="form-control form-control-user" type="text"
                                required="true" name="travel_plan_name" id="travel_plan_name">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('itinerary.create') }}" method="GET" class="col-sm-6"
                            style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                            @csrf
                            <h3 class="text-start text-primary"> Servicios</h3>
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText" placeholder="Buscar servicio"
                                    value="{{ $searchText }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    @if (!isset($services))
                        <div class="alert alert-danger">
                            <strong>No hay servicios disponibles.</strong>
                        </div>
                    @endif
                    <div class="table-container" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 7em;">Tipo de servicio</th>
                                    <th style="width: 7em;">Origen</th>
                                    <th style="width: 7em;">Dest. Ida</th>
                                    <th style="width: 6em;">Hora recogida</th>
                                    <th style="width: 6em;">Hora llegada</th>
                                    <th style="width: 4em;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($services))
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>{{ str_replace('eSrv', 'o', class_basename($service->service_type)) }}</td>
                                            <td>{{ $service->origin_going }}</td>
                                            <td>{{ $service->destination_going }}</td>
                                            <td>{{ $service->hour_pickup_going }}</td>
                                            <td>{{ $service->hour_arrival_going }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-add-service" type="button"
                                                    data-service-id="{{ $service->id }}"><i
                                                        class="fas fa-plus-circle"></i></button>
                                                <button class="btn btn-danger btn-remove-service" type="button"
                                                    data-service-id="{{ $service->id }}"><i
                                                        class="far fa-trash-alt"></i>Quitar</button>

                                                <a class="btn btn-info" type="button"
                                                    href="{{ route('services.show', $service->id) }}" target="_blank"
                                                    style="margin-right: 13px;border-style: none;">
                                                    <i class="far fa-list-alt"></i>Detalles</a>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="display: inline-flex;margin-bottom: 5em;margin-top: 1em;"><button id="btn-confirm"
                            class="btn btn-primary" type="button"
                            style="background: rgb(25,135,84);margin-right: 5em;border-style: none;">Confirmar</button><button
                            class="btn btn-primary" type="button"
                            style="background: rgb(220,53,69);border-style: none;">Cancelar</button>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
    </div>

    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script>
        $(document).ready(function() {
            function warningAlert(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debes completar todos los campos. ' + message,
                });
            };

            $('.btn-remove-service').hide(); //Oculto boton quitar de entrada
            let selectedServices = []; //Arreglo con id de servicios seleccionados

            $('.btn-add-service').click(function() {
                const serviceId = $(this).data('service-id');
                if (selectedServices.indexOf(serviceId) === -1) {
                    selectedServices.push(serviceId); //Agregar servicio a array temporal
                }
                $(this).hide();
                $(this).siblings('.btn-remove-service').show();
            });

            $('.btn-remove-service').click(function() {
                const serviceId = $(this).data('service-id');
                const index = selectedServices.indexOf(serviceId);
                if (index > -1) {
                    selectedServices.splice(index, 1); //Eliminar servicio de array temporal
                }
                $(this).hide();
                $(this).siblings('.btn-add-service').show();
            });

            const csrfToken = $('meta[name="csrf-token"]').attr(
                'content'); //Token para permitir hacer consulta AJAX
            $('#btn-confirm').click(function() {
                if (selectedServices.length === 0) { //Si no seleccionó servicios
                    warningAlert("No ha seleccionado ningún servicio.");
                    return;
                }
                if ($("#travel_plan_name").val() == "") { //Si no le dió nombre al itinerario
                    warningAlert("Debe ingresar un nombre para el itinerario.");
                    return;
                }

                $.ajax({ //Enviar id de servicios al método del controlador
                    type: "POST",
                    url: "{{ route('itinerary.store') }}",
                    data: {
                        _token: csrfToken,
                        services: selectedServices,
                        itineraryName: $("#travel_plan_name").val()
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Itinerario creado con éxito.',
                            text: "Podrás editarlo mas tarde.",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#198754',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {

                            window.location.href = "{{ route('itinerary.index') }}";
                        });
                    },

                    error: function(response) {
                        Swal.fire({
                            title: 'Error al crear itinerario.',
                            text: "Vuelve a intentarlo.",
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#198754',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            window.location.href = "{{ route('itinerary.index') }}";
                        });
                    }
                });
            });

        });
    </script>
@endsection
