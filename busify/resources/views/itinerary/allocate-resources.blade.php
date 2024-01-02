@extends('layouts.principal')
{{-- @can('itinerary.allocate-resources') acceso unicamente por el usuario con rol de supervisor --}}
@section('title', 'Alocar recursos')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Alocar recursos</h2>
                    <p>Seleccione los recursos que desee alocar para el itinerario</p>
                </div>
                <form action="{{ route('itinerary.update', $travelPlan->id) }}" method="POST"
                    style="width: 43em;max-width: none;">
                    @csrf
                    @method('PUT')
                    <h3 style="margin-bottom: 1em;text-align: center;">Recursos (Itinerario Nro. {{ $travelPlan->id }})</h3>
                    <div style="margin: 1em;">
                        <span>Cantidad de servicios del itinerario:</span><strong> {{ $servicesAmount }}</strong>
                    </div>
                    <div style="display: flex;justify-content: space-between;">
                        <div class="mb-3">
                            <label class="form-label" for="password"><i class="fas fa-user"
                                    style="margin-right: 0.5em;"></i>Chofer</label>
                            <div class="dropdown">
                                <select name="driverSelect" id="" class="form-select" style="width: 10em;">
                                    <option value="">Seleccione...</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">
                                            {{ $driver->user->name . ' ' . $driver->user->lastName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div><label class="form-label"><strong>Chofer actual</strong></label>
                            <div class="row mb-3"
                                title="{{ $travelPlan->driver ? $travelPlan->driver->user->name . ' ' . $travelPlan->driver->user->lastName : 'SIN ASIGNAR' }}">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input
                                        class="form-control form-control-user" type="text" id="nombre-id-1"
                                        required="true" name="nro-servicio" readonly="" disabled=""
                                        style="width: 100%;"
                                        value="{{ $travelPlan->driver ? $travelPlan->driver->user->name . ' ' . $travelPlan->driver->user->lastName : 'SIN ASIGNAR' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex;justify-content: space-between;">
                        <div class="mb-3" ><label class="form-label" for="email"><i
                                    class="fas fa-bus" style="margin-right: 0.5em;"></i>Unidad (asientos
                                disponibles)</label>
                            <div class="dropdown">
                                <select name="unitSelect" id="" class="form-select" style="width: 10em;">
                                    <option value="">Seleccione...</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit_patent . ' (' . $unit->unit_total_capacity . ')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div><label class="form-label"><strong>Unidad actual</strong></label>
                            <div class="row mb-3"
                                title="{{ $travelPlan->unit ? $travelPlan->unit->unit_patent : 'SIN ASIGNAR' }}">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input
                                        class="form-control form-control-user" type="text" id="nombre-id-2"
                                        required="true" name="nro-servicio" readonly="" disabled=""
                                        style="width: 100%;"
                                        value="{{ $travelPlan->unit ? $travelPlan->unit->unit_patent : 'SIN ASIGNAR' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3" style="display: flex;justify-content: space-between;">
                        <div><label class="form-label" for="email"><i class="fas fa-eye"
                                    style="margin-right: 0.5em;"></i>Asistente</label>
                            <div class="dropdown">
                                <select name="assistantSelect" id="" class="form-select" style="width: 10em;">
                                    <option value="">Seleccione...</option>
                                    @foreach ($assistants as $assistant)
                                        <option value="{{ $assistant->id }}">
                                            {{ $assistant->assistant_name . ' ' . $assistant->assistant_last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">
                                <strong>Asistente actual (CUIL)</strong>
                            </label>
                            <div class="row mb-3"
                                title="{{ $travelPlan->assistant
                                    ? $travelPlan->assistant->assistant_name .
                                        ' ' .
                                        $travelPlan->assistant->assistant_last_name .
                                        ' (' .
                                        $travelPlan->assistant->assistant_cuil .
                                        ')'
                                    : 'SIN ASIGNAR' }}">
                                <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input
                                        class="form-control form-control-user" type="text" id="nombre-id-3"
                                        required="true" name="nro-servicio" readonly="" disabled=""
                                        style="width: 100%;"
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
                    </div>
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="d-flex flex-row justify-content-between justify-content-xl-center" style="margin-top: 2em;">
                        <button class="btn btn-success d-xl-flex mx-auto" type="submit">Confirmar</button><a
                            href="{{ route('itinerary.index') }}" class="btn btn-danger d-xl-flex mx-auto"
                            type="button">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
{{-- @endcan --}}
