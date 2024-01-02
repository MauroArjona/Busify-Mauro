@extends('layouts.principal')
{{-- @can('itinerary.edit') acceso unicamente por el usuario con rol de supervisor --}}
@section('title', 'Lista servicios')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Lista de Servicios</h2>
                    <p>Lista de servicios cargados en el sistema.</p>

                    <form id="search-form" action="{{ route('service.list-services') }}" method="GET" class="col-sm-6"
                        style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Buscar servicios">
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
                                    <th style="padding-left: 4px;margin-left: 3px;width: 15em;">Estado</th>
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

                                        @if ($service->service_state == 'SIN_ASIGNAR')
                                            <td>SIN ASIGNAR</td>
                                        @endif
                                        @if ($service->service_state == 'ASIGNADO')
                                            <td>ASIGNADO</td>
                                        @endif
                                        <td><a target="_blank" class="btn btn-info"
                                                href="{{ route('services.show', $service->id) }}" role="button"><i
                                                    class="far fa-list-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $services->links() }}
                </div>
            </div>
        </section>
    </main>
@endsection
