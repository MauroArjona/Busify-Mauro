@extends('layouts.principal')

@section('title', 'Detalles contrato')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container">
                <h2 class="text-info" style="text-align: center;padding: 0;padding-top: 1em;margin-bottom: 1em;">
                    Contrato Nro. {{ $contract->id }}</h2>
                <div style="display: flex;justify-content: space-between;">
                    <div style="display: flex;text-align: center;"><label class="form-label form-label"
                            style="width: 10em;"><strong>Fecha de inicio</strong></label>
                        <div class="row mb-3" style="width: 27em;margin: 0;padding: 0;">
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                    class="form-control form-control-user" disabled="" name="contract_start_date"
                                    readonly="" value="{{ $contract->contract_start_date }}"></div>
                        </div>
                    </div>
                    <div style="display: flex;text-align: center;"><label class="form-label form-label"
                            style="width: 13em;"><strong>Fecha de fin</strong></label>
                        <div class="row mb-3" style="width: 27em;margin: 0;">
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                    class="form-control form-control-user" disabled="" name="contract_end_date"
                                    readonly=""
                                    value="{{ $contract->contract_end_date ? $contract->contract_end_date : 'Sin especificar' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex;justify-content: space-between;">
                    <div style="display: flex;text-align: center;justify-content: space-between;"><label
                            class="form-label form-label" style="width: 10em;"><strong>Monto</strong></label>
                        <div class="row mb-3" style="width: 27em;margin: 0;padding: 0;">
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                    class="form-control form-control-user" disabled="" name="contract_montly_fee"
                                    readonly="" value="${{ number_format($contract->contract_montly_fee, 2, '.', ',') }}">
                            </div>
                        </div>
                    </div>
                    <div style="display: flex;text-align: center;"><label class="form-label form-label"
                            style="width: 13em;"><strong>Estado</strong></label>
                        <div class="row mb-3" style="width: 27em;margin: 0;">
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                    class="form-control form-control-user" disabled="" name="unit" readonly=""
                                    value="{{ $contract->contract_state == 'ESPERANDO_APROBACION' ? 'ESPERANDO APROBACIÓN' : $contract->contract_state }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex;justify-content: space-between;">
                    <div style="display: flex;text-align: center;"><label class="form-label form-label"
                            style="width: 10em;"><strong>Cliente</strong></label>
                        <div class="row mb-3" style="width: 27em;margin: 0;padding: 0;"
                            title="{{ $contract->client->user->name }} {{ $contract->client->user->lastName }}">
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;"><input type="text"
                                    class="form-control form-control-user" disabled="" name="contract_client"
                                    readonly=""
                                    value="{{ $contract->client->user->name }} {{ $contract->client->user->lastName }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-heading" style="padding:1em 5em;">
                <h3 class="text-start text-primary">Servicios</h3>
                <form action="" method="GET"
                    class="col-sm-6"style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchText" placeholder="Buscar servicio"
                            value="">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                        </span>
                    </div>
                </form>
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
                                    <td><a target="_blank" href="{{ route('passenger.show', $service->passenger->id) }}"><i
                                                class="fas fa-info-circle"></i>{{ $service->passenger->passenger_name . ' ' . $service->passenger->passenger_last_name }}
                                    </td>
                                    <td>{{ $service->origin_going }}</td>
                                    <td>{{ $service->destination_going }}</td>
                                    <td><a target="_blank" class="btn btn-info" href="{{ route('services.show', $service->id) }}"
                                            role="button" style="margin-right: 13px;"><i
                                                class="far fa-list-alt"></i>Detalles</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $services->links() }}
            </div>
        </section>
    </main>
@endsection
