@extends('layouts.principal')

@section('title', 'Detalles parte de viaje')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container">
                <h2 class="text-info" style="text-align: center; margin: 1em 0;">
                    {{ !auth()->user()->hasRole('Supervisor')? 'Modificar': 'Detalles' }} parte de viaje
                    Nro.{{ $travelReport->id }}
                </h2>
                <div class="row mb-3">
                    <div class="col-md-8 offset-md-2">
                        <form method="POST" action="{{ route('travel-report.update', $travelReport->id) }}"
                            style="background:transparent; border:none; margin:unset;"
                            onsubmit="validateTravelReport(event, this);">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label form-label">
                                    <strong>Descripción del parte de viaje</strong>
                                </label>

                                <textarea id="description-id" style="max-height: 13em; box-shadow: none;" class="form-control"
                                    @can('travel-report.read') disabled @endcan name="description">{{ $travelReport->description }}</textarea>


                            </div>
                            @can('travel-report.modify')
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            @endcan
                        </form>
                    </div>
                </div>
                @if (Session::has('errorDescription'))
                    <div class="alert alert-danger">
                        {{ Session::get('errorDescription') }}
                    </div>
                @endif
                @if (Session::has('successDescription'))
                    <div class="alert alert-success">
                        {{ Session::get('successDescription') }}
                    </div>
                @endif
                <div class="block-heading" style="padding:1em 5em;">
                    <h3 class="text-start text-primary">Eventos</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 9em;">Nombre del evento</th>
                                    <th style="width: 16em;">Descripción</th>
                                    <th style="width: 16em;">Hora del evento</th>
                                    <th style="width: 16em;">Fecha de creación</th>
                                    @can('travel-report.modify')
                                        <th style="width: 10em;">Acciones</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        <td>{{ $event->event_name }}</td>
                                        <td>{{ $event->event_description }}</td>
                                        <td>{{ $event->event_hour }}</td>
                                        <td>{{ $event->created_at }} </td>
                                        @can('travel-report.modify')
                                            <td>
                                                <a class="btn btn-warning" href="{{ route('event.edit', $event->id) }}"
                                                    role="button">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <form action="{{ route('event.destroy', $event->id) }}" class="delete-record"
                                                    method="POST" onsubmit="removalAlert(event, this);"
                                                    style="display: inline; margin: 0; padding: 0; border-top: none; background-color: transparent; box-shadow: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit"><i
                                                            class="far fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $events->links() }}
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
