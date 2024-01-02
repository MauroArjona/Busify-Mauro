@extends('layouts.principal')

@section('title', 'Editar evento')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading" style="padding: 1em;">
                    <h2 class="text-primary">Editar Evento</h2>
                    <hr>
                    <form action="{{ route('event.update', $event->id) }}" method="post" onsubmit="createEventAlert(event, this);">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="event_name" class="form-label">Nombre del evento</label>
                            <input type="text" class="form-control" id="event_name" name="event_name"
                                value="{{ $event->event_name }}">
                        </div>
                        <div class="mb-3">
                            <label for="event_description" class="form-label">Descripción del evento</label>
                            <textarea class="form-control" id="event_description" name="event_description" rows="5" style="max-height: 15em;">{{ $event->event_description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="event_hour" class="form-label">Hora del evento</label>
                            <input type="time" class="form-control" id="event_hour" name="event_hour"
                                value="{{ $event->event_hour }}">
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
