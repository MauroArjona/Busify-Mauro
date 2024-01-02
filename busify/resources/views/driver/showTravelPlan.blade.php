@extends('layouts.principal')

@section('title', 'Detalles itinerario')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            @if (isset($travelPlan) && isset($services))


                <div class="container">
                    <h2 class="text-info" style="text-align: center;padding: 0;padding-top: 1em;margin-bottom: 1em;">
                        Itinerario Nro. {{ $travelPlan->id }}</h2>
                    <div style="display: flex;justify-content: space-between;">
                        <div style="display: flex;text-align: center;"><label class="form-label form-label"
                                style="width: 10em;"><strong>Nombre itinerario</strong></label>
                            <div class="row mb-3" style="width: 27em;margin: 0;padding: 0;">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                        class="form-control form-control-user" disabled="" name="nameItinerary"
                                        readonly="" value="{{ $travelPlan->travel_plan_name }}"></div>
                            </div>
                        </div>
                        <div style="display: flex;text-align: center;"><label class="form-label form-label"
                                style="width: 13em;"><strong>Cantidad de pasajeros</strong></label>
                            <div class="row mb-3" style="width: 27em;margin: 0;">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                        class="form-control form-control-user" disabled="" name="passengerAmount"
                                        readonly="" value="{{ $travelPlan->passenger_amount }}"></div>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex;justify-content: space-between;">
                        <div style="display: flex;text-align: center;justify-content: space-between;"><label
                                class="form-label form-label" style="width: 10em;"><strong>Asistente (CUIL)</strong></label>
                            <div class="row mb-3" style="width: 27em;margin: 0;padding: 0;">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                        class="form-control form-control-user" disabled="" name="assistantDetail"
                                        readonly=""
                                        value="{{ $travelPlan->assistant
                                            ? $travelPlan->assistant->assistant_name .
                                                ' ' .
                                                $travelPlan->assistant->assistant_last_name .
                                                ' (' .
                                                $travelPlan->assistant->assistant_cuil .
                                                ')'
                                            : 'SIN ASIGNAR' }}">
                                </div>
                            </div>
                        </div>
                        <div style="display: flex;text-align: center;"><label class="form-label form-label"
                                style="width: 13em;"><strong>Unidad asignada</strong></label>
                            <div class="row mb-3" style="width: 27em;margin: 0;">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                        class="form-control form-control-user" disabled="" name="unit" readonly=""
                                        value="{{ $travelPlan->unit ? $travelPlan->unit->unit_patent : 'SIN ASIGNAR' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex;justify-content: space-between;">
                        <div style="display: flex;text-align: center;"><label class="form-label form-label"
                                style="width: 10em;"><strong>Chofer asignado</strong></label>
                            <div class="row mb-3" style="width: 27em;margin: 0;padding: 0;">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                        class="form-control form-control-user" disabled="" name="driver" readonly=""
                                        value="{{ $travelPlan->driver ? $travelPlan->driver->user->name . ' ' . $travelPlan->driver->user->lastName : 'SIN ASIGNAR' }}">
                                </div>
                            </div>
                        </div>
                        <div style="display: flex;text-align: center;"><label class="form-label form-label"
                                style="width: 13em;"><strong>Supervisor</strong></label>
                            <div class="row mb-3" style="width: 27em;margin: 0;">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                        class="form-control form-control-user" disabled="" name="supervisor"
                                        readonly=""
                                        value="{{ $travelPlan->supervisor
                                            ? $travelPlan->supervisor->user->name . ' ' . $travelPlan->supervisor->user->lastName
                                            : 'SIN ASIGNAR' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-heading" style="padding:1em 5em;">
                    <h3 class="text-start text-primary">Servicios</h3>
                    <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 9em;">Tipo de servicio</th>
                                    <th style="width: 16em;">Pasajero</th>
                                    <th style="width: 16em;">Origen</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 20em;">Dest. Ida</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 8em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ str_replace('eSrv', 'o', class_basename($service->service_type)) }}</td>
                                        <td><a target="_blank"
                                                href="{{ route('passenger.show', $service->passenger->id) }}"><i
                                                    class="fas fa-info-circle"></i>{{ $service->passenger->passenger_name . ' ' . $service->passenger->passenger_last_name }}
                                        </td>
                                        <td>{{ $service->origin_going }}</td>
                                        <td>{{ $service->destination_going }}</td>
                                        <td><a target="_blank" class="btn btn-info"
                                                href="{{ route('services.show', $service->id) }}" role="button"
                                                style="margin-right: 13px;"><i class="far fa-list-alt"></i>Detalles</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $services->links() }}
            @endif
            @if (!isset($services) && !isset($travelPlan))
                <div class="alert alert-danger" style="text-align: center;">
                    No tiene itinerario asignado.
                </div>
            @endif
            </div>
        </section>
    </main>
@endsection
