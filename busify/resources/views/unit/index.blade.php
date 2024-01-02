@extends('layouts.principal')
@section('title', 'Listar unidades')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Listar unidades</h2>
                    <p>Lista de unidades cargadas en el sistema. Tiene la posibilidad de agregar una nueva unidad.</p>

                    <div class="d-flex justify-content-between align-items-center">

                        <form action="{{ route('unit.index') }}" method="GET" class="col-sm-6"
                            style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText" placeholder="Buscar patente"
                                    value="{{ $searchText }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                                </span>
                            </div>
                        </form>
                        <a class="btn btn-primary" href="{{ route('unit.create') }}" role="button"><i
                                class="fas fa-plus-circle"></i><span style="background-color: rgb(13, 110, 253);">Agregar
                                unidad</span></a>
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
                    <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15em;">Estado</th>
                                    <th style="width: 45em;">Patente</th>
                                    <th style="width: 45em;">Marca</th>
                                    <th style="width: 45em;">Modelo</th>
                                    <th style="width: 25em;">Capacidad total</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 18em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                    <tr>
                                        <td>{{ $unit->unit_state }}</td>
                                        <td>{{ $unit->unit_patent }}</td>
                                        <td>{{ $unit->unit_brand }}</td>
                                        <td>{{ $unit->unit_model }}</td>
                                        <td>{{ $unit->unit_total_capacity }}</td>
                                        <td class="d-flex gap-3 justify-content-center">

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#Modal{{ $unit->id }}">
                                                <i class="far fa-list-alt"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="Modal{{ $unit->id }}" tabindex="-1"
                                                aria-labelledby="ModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="ModalLabel">Detalles de la
                                                                Unidad de Transporte
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <tr>
                                                                    <td>
                                                                        <strong>Patente:</strong>
                                                                    </td>
                                                                    <td>{{ $unit->unit_patent }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Marca:</strong></td>
                                                                    <td>{{ $unit->unit_brand }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Modelo:</strong></td>
                                                                    <td>{{ $unit->unit_model }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Estado:</strong></td>
                                                                    <td>{{ $unit->unit_state }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Capacidad Total:</strong>
                                                                    </td>
                                                                    <td>{{ $unit->unit_total_capacity }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Kilometraje:</strong></td>
                                                                    <td> {{ $unit->unit_mileage }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Observaciones:</strong>
                                                                    </td>
                                                                    <td>{{ $unit->unit_detail ? $unit->unit_detail : 'Sin observaciones' }} </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="btn btn-warning" href="{{ route('unit.edit', $unit->id) }}"
                                                role="button"><i class="far fa-edit"></i></a>
                                            <form action="{{ route('unit.destroy', $unit->id) }}" class="delete-record"
                                                method="POST" onsubmit="removalAlert(event, this);"
                                                style="display: inline;margin: 0;padding:0;border-top: none; background-color: transparent; box-shadow: none;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"><i
                                                        class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $units->links() }}
                </div>

            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
