@extends('layouts.principal')
@section('title', 'Listar partes de viaje')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Listar partes de viaje</h2>
                    <p>Lista de partes de viaje cargados en el sistema. Tiene la posibilidad de agregar o modificar un parte
                        de viaje.</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('travel-report.index') }}" method="GET" class="col-sm-6"
                            style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText"
                                    placeholder="Buscar por fecha o descripción">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                                </span>
                            </div>
                        </form>
                        <a class="btn btn-primary" href="{{ route('travel-report.create') }}" role="button"><i
                                class="fas fa-plus-circle"></i><span style="background-color: rgb(13, 110, 253);">Agregar
                                parte de viaje</span></a>
                    </div>

                    <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15em;">Fecha de parte</th>
                                    <th style="width: 45em;">Descripción</th>
                                    <th style="width: 45em;">Itinerario</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 22em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($travel_reports as $travel_report)
                                    <tr>
                                        <td>{{ $travel_report->travel_report_date }}</td>
                                        <td>{{ $travel_report->description }}</td>
                                        <td>{{ $travel_report->travelPlan->travel_plan_name ?? 'Sin itinerario' }}</td>
                                        <td>
                                            <a class="btn btn-warning"
                                                href="{{ route('travel-report.edit', $travel_report->id) }}"
                                                role="button"><i class="far fa-edit"></i></a>
                                            <form action="{{ route('travel-report.destroy', $travel_report->id) }}"
                                                class="delete-record" method="POST" onsubmit="removalAlert(event, this);"
                                                style="display: inline; margin: 0; padding: 0; border-top: none; background-color: transparent; box-shadow: none;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"><i
                                                        class="far fa-trash-alt"></i></button>
                                            </form>
                                            <a target="_blank" class="btn btn-info"
                                                href="{{ route('event.show', $travel_report->id) }}" role="button"><i
                                                    class="far fa-list-alt"></i>Eventos</a>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $travel_reports->links() }}
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
