@extends('layouts.principal')

@section('title', 'Detalles itinerario')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container">
                <h2 class="text-info" style="text-align: center;padding: 0;padding-top: 1em;margin-bottom: 1em;">
                    Parte de viaje para Itinerario Nro. {{ $id }}</h2>
                <div style="display: flex;justify-content: space-between;">
                    <div style="display: flex;text-align: center;"><label class="form-label form-label"
                            style="width: 10em;"><strong>Descripción parte de viaje</strong></label>
                        <div class="row mb-3" style="width: 27em;margin: 0;padding: 0;">
                            <div class="col-sm-6 mb-3 mb-sm-0" style="width: 100%;">
                                <textarea style="max-height: 10em;" type="text" class="form-control form-control-user" disabled=""
                                    name="nameItinerary" readonly="" value="{{ $travelReport->description }}">
                                    {{ $travelReport->description }}</textarea>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="block-heading" style="padding:1em 5em;">
                <a class="btn btn-primary float-end" role="button" data-bs-toggle="modal" data-bs-target="#Modal"><i
                        class="fas fa-plus-circle"></i><span style="background-color: rgb(13, 110, 253);">Agregar
                        evento</span></a>
                <h3 class="text-start text-primary">Eventos</h3>
                <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ModalLabel">Agregar evento
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('event.store') }}" method="post"
                                    style="background: none; border: none;padding:0;max-width:none;"
                                    onsubmit="createEventAlert(event, this);">
                                    @csrf
                                    <table class="table">
                                        <tr>
                                            <td><strong>Nombre del evento:</strong></td>
                                            <td>
                                                <input placeholder="Obligatorio" class="form-control" type="text"
                                                    id="name" name="event_name">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td><strong>Descripción del evento:</strong></td>
                                            <td>
                                                <textarea placeholder="Obligatorio" class="form-control" type="text" name="event_description" id="event_description"></textarea>
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr title="Obligatorio">
                                            <td><strong>Hora del evento:</strong></td>
                                            <td><input class="form-control" type="time" id="event_hour"
                                                    name="event_hour"></td>
                                        </tr>
                                    </table>
                                    <div class="error-datos" style="color: #ff0000">

                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Agregar</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 9em;">Nombre del evento</th>
                                <th style="width: 16em;">Descripción</th>
                                <th style="width: 16em;">Hora del evento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($events))
                                @foreach ($events as $event)
                                    <tr>
                                        <td>{{ $event->event_name }}</td>
                                        <td>{{ $event->event_description }}</td>
                                        <td>{{ $event->event_hour }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @if (isset($events))
                    {{ $events->links() }}
                @endif
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
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
