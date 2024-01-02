@extends('layouts.principal')
@section('title', 'Modificar unidad')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container focus-ring focus-ring-primary">
                <div class="block-heading">
                    <h2 class="text-info">Modificar unidad</h2>
                    <p>Complete los datos solicitados para modificar una unidad.</p>
                </div>
                <form action="{{ route('unit.update', $unit->id) }}" method="POST" onsubmit="updateUnit(event,this);"
                    class="save-record">
                    @csrf
                    @method('PUT')
                    <h3>Unidad</h3>
                    <hr>
                    <div class="border-secondary-subtle focus-ring focus-ring-primary mb-3"style="padding: 0.2em;">
                        <strong>Patente</strong>
                        <input class="form-control" type="text" name="unit_patent"placeholder="Patente" id="unit_patent"
                            value="{{ $unit->unit_patent }}">
                    </div>
                    <div class="border-secondary-subtle focus-ring focus-ring-primary mb-3" style="padding: 0.2em;">
                        <strong>Capacidad total</strong>
                        <input class="form-control" type="number" name="unit_total_capacity" placeholder="Capacidad total"
                            id="total_capacity" value="{{ $unit->unit_total_capacity }}" min="1" max="15">
                    </div>
                    <div class="border-secondary-subtle focus-ring focus-ring-primary mb-3" style="padding: 0.2em;">
                        <strong>Modelo</strong>
                        <input class="form-control" type="text" name="unit_model" placeholder="Modelo"
                            value="{{ $unit->unit_model }}" id="model">
                    </div>
                    <div class="border-secondary-subtle focus-ring focus-ring-primary mb-3" style="padding: 0.2em;">
                        <strong>Marca</strong>
                        <input class="form-control" type="text" name="unit_brand" placeholder="Marca"
                            value="{{ $unit->unit_brand }}" id="brand">
                    </div>
                    <div class="border-secondary-subtle focus-ring focus-ring-primary mb-3" style="padding: 0.2em;">
                        <strong>Kilometraje</strong>
                        <input class="form-control" type="number" name="unit_mileage" placeholder="Kilometraje"
                            value="{{ $unit->unit_mileage }}" id="unit_mileage">
                    </div>
                    <div class="border-secondary-subtle focus-ring focus-ring-primary mb-3" style="padding: 0.2em;">
                        <strong>Estado</strong>
                        <select class="form-select" name="unit_state" id="unit_state">
                            <option value="Disponible" {{ $unit->unit_state == 'DISPONIBLE' ? 'selected' : '' }}>Disponible
                            </option>
                            <option value="Desafectada" {{ $unit->unit_state == 'DESAFECTADA' ? 'selected' : '' }}>
                                Desafectada
                            </option>
                        </select>
                    </div>
                    <div class="border-secondary-subtle focus-ring focus-ring-primary mb-3" style="padding: 0.2em;"
                        id="container-detail" @if ($unit->unit_state == 'DISPONIBLE') hidden @endif>
                        <textarea style="max-height: 13em" class="form-control" type="text" name="unit_detail"
                            placeholder="Motivo de cambio de estado" id="unit_detail">
    @if ($unit->unit_state == 'DESAFECTADA')
{{ $unit->unit_detail }}
@endif
</textarea>
                    </div>
                    <div class="d-flex flex-row justify-content-between justify-content-xl-center"><button
                            class="btn btn-success d-xl-flex mx-auto" type="submit">Guardar</button><a
                            class="btn btn-danger d-xl-flex mx-auto" href="{{ route('unit.index') }}">Cancelar</a></div>
                </form>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#unit_state').change(function() {
                if ($(this).val() == 'Desafectada') {
                    $('#container-detail').removeAttr('hidden');
                } else {
                    $('#container-detail').attr('hidden', true);
                }
            });
        });
    </script>
@endsection
