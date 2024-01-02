@extends('layouts.principal')
{{-- @can('itinerary.edit') acceso unicamente por el usuario con rol de supervisor --}}
@section('title', 'Modificar itinerario')
@section('content')
<main class="page registration-page" style="height: 100%;">
    <section class="clean-block clean-form dark" style="height: 100%;">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Modificar itinerario (Nro. {{ $travelPlan->id }})</h2>
                <p>Puede agregar o quitar servicios del itinerario, así como también alocar recursos (unidad, chofer y
                    ayudante)</p>
                <h3 class="text-start text-primary"><a class="btn btn-primary float-end" role="button" style="margin-right: 0.5em;margin-left: 0.5em;" href="{{ route('itinerary.allocate-resources', $travelPlan->id) }}"><i class="fas fa-bus"></i>Alocar recursos</a>

                    {{-- Botón agregar servicio que despliega modal --}}
                    <button class="btn btn-success float-end" type="button" data-bs-toggle="modal" data-bs-target="#Modal" style="margin-right: 0.5em;margin-left: 0.5em;"><i class="fas fa-plus-circle"></i>Agregar servicio</button>

                    Servicios
                </h3>
                {{-- Modal con tabla de servicios para agregar --}}
                <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ModalLabel">Agregar servicio
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 8em;">Tipo de servicio</th>
                                            <th style="width: 10em;">Pasajero</th>
                                            <th style="width: 7em;">Origen</th>
                                            <th style="width: 7em;">Destino</th>
                                            <th style="width: 4em;">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($servicesToAssign as $serviceToAssign)
                                        <tr>
                                            <td>
                                                {{ str_replace('eSrv', 'o', class_basename($serviceToAssign->service_type)) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('passenger.show', $serviceToAssign->passenger->id) }}">
                                                    <i class="fas fa-info-circle"></i>
                                                    {{ $serviceToAssign->passenger->passenger_name . ' ' . $serviceToAssign->passenger->passenger_last_name }}</a>
                                            </td>
                                            <td>{{ $serviceToAssign->origin_going }}</td>
                                            <td>{{ $serviceToAssign->destination_going }}</td>
                                            <td>
                                                <a target="_blank" class="btn btn-info" type="button" style="margin-right: 13px;" href="{{ route('services.show', $serviceToAssign->id) }}">
                                                    <i class="far fa-list-alt"></i>Detalles
                                                </a>
                                                {{-- formulario y botón para agregar servicio al itinerario y recargar página --}}

                                                <form action="{{ route('itinerary.add-service', [$travelPlan->id, $serviceToAssign->id])}}" class="delete-record" method="POST" onsubmit="saveItinerary(event, this);" style="display: inline;margin: 0;padding:0;border-top: none; background-color: transparent; box-shadow: none;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-success" type="submit" style="margin-right: 13px;"><i class="fas fa-plus-circle"></i>Agregar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="error-datos" style="color: #ff0000">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;width: 85em;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 8em;">Tipo de servicio</th>
                                <th style="width: 10em;">Pasajero</th>
                                <th style="width: 7em;">Origen</th>
                                <th style="width: 7em;">Destino</th>
                                <th style="width: 4em;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                            <tr>
                                <td>
                                    {{ str_replace('eSrv', 'o', class_basename($service->service_type)) }}
                                </td>
                                <td><a href="{{ route('passenger.show', $service->passenger->id) }}"><i class="fas fa-info-circle"></i>
                                        {{ $service->passenger->passenger_name . ' ' . $service->passenger->passenger_last_name }}</a>
                                </td>
                                <td>{{ $service->origin_going }}</td>
                                <td>{{ $service->destination_going }}</td>
                                <td>
                                    <a target="_blank" class="btn btn-info" type="button" style="margin-right: 13px;" href="{{ route('services.show', $service->id) }}">
                                        <i class="far fa-list-alt"></i>Detalles
                                    </a>
                                    <form action="{{ route('itinerary.destroy-service', $service->id) }}" class="delete-record" method="POST" onsubmit="removalAlert(event, this);" style="display: inline;margin: 0;padding:0;border-top: none; background-color: transparent; box-shadow: none;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" style="margin-right: 13px;"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                {{ $services->links() }}
            </div>
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
        </div>
    </section>
</main>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
<script src="{{ asset('js/alert.js') }}"></script>
@endsection
{{-- @endcan --}}