@extends('layouts.principal')
@section('title', 'Lista itinerario')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Lista de Itinerarios</h2>
                    <p>Lista de itinerarios cargados en el sistema.</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('itinerary.index') }}" method="GET" class="col-sm-6"
                            style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText" placeholder="Buscar itinerario"
                                    value="{{ $searchText }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                                </span>
                            </div>
                        </form>
                        <a class="btn btn-primary" href="{{ route('itinerary.create') }}" role="button"><i
                                class="fas fa-plus-circle"></i><span style="background-color: rgb(13, 110, 253);">Crear
                                itinerario</span></a>
                    </div>

                    <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15em;">Nombre itinerario</th>
                                    <th style="width: 13em;">Cantidad pasajeros</th>
                                    <th style="width: 15em;">Fecha creación</th>
                                    <th style="width: 15em;">Última modificación</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 20em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($travelPlans as $travelPlan)
                                    <tr>
                                        <td>{{ $travelPlan->travel_plan_name }}</td>
                                        <td>{{ $travelPlan->passenger_amount }}</td>
                                        <td>{{ $travelPlan->created_at }}</td>
                                        <td>{{ $travelPlan->updated_at }}</td>
                                        <td>
                                            <a target="_blank" href="{{ route('itinerary.show', $travelPlan->id) }}" class="btn btn-info"
                                                type="button" style="margin-right: 13px;"><i
                                                    class="far fa-list-alt"></i>Detalles</a>
                                            <a href="{{ route('itinerary.edit', $travelPlan->id) }}" class="btn btn-warning"
                                                type="button" style="margin-right: 13px;"><i class="far fa-edit"></i></a>
                                            <form action="{{ route('itinerary.destroy', $travelPlan->id) }}"
                                                class="delete-record" method="POST" onsubmit="removalAlert(event, this);"
                                                style="display: inline;margin: 0;padding:0;border-top: none; background-color: transparent; box-shadow: none;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit" style="margin-right: 13px;"><i
                                                        class="far fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $travelPlans->links() }}
                </div>
                @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
