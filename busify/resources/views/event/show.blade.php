@extends('layouts.principal')

@section('title', 'Detalles itinerario')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container">
                <h2 class="text-info" style="text-align: center;padding: 0;padding-top: 1em;margin-bottom: 1em;">
                    Parte de viaje Nro. {{ $travelReport->id }}</h2>
                <div style="display: flex;justify-content: space-between;">
                    <div style="display: flex;text-align: center;"><label class="form-label form-label"
                            style="width: 10em;"><strong>Descripción del parte de viaje</strong></label>
                        <div class="row mb-3" style="width: 27em;margin: 0;padding: 0;">
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;">
                                <textarea style="max-height:15em;" type="text" class="form-control form-control-user" disabled=""
                                    name="nameItinerary" readonly="" value="{{ $travelReport->description }}">
                                    {{ $travelReport->description }}</textarea>

                            </div>
                        </div>
                        <div class="row mb-3" style="width: 16em;margin: 0;padding: 0;">
                            <strong>KM de la unidad al iniciar</strong>
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input style="max-height:15em;"
                                    type="text" class="form-control form-control-user" disabled=""
                                    name="nameItinerary" readonly="" value="{{ $travelReport->mileage_start }}">
                            </div>
                        </div>
                        <div class="row mb-3" style="width: 16em;margin: 0;padding: 0;">
                            <strong>KM de la unidad al finalizar</strong>
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input style="max-height:15em;"
                                    type="text" class="form-control form-control-user" disabled=""
                                    name="nameItinerary" readonly="" value="{{ $travelReport->mileage_end }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-heading" style="padding:1em 5em;">
                <h3 class="text-start text-primary">Eventos</h3>

                <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 9em;">Nombre del evento</th>
                                <th style="width: 16em;">Descripción</th>
                                <th style="width: 16em;">Hora del evento</th>
                                <th style="width: 16em;">Fecha de creación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->event_name }}</td>
                                    <td>{{ $event->event_description }}</td>
                                    <td>{{ $event->event_hour }}</td>
                                    <td>{{ $event->created_at }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $events->links() }}
            </div>
        </section>
    </main>
@endsection
