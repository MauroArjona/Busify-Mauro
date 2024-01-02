@extends('layouts.principal')
@section('title', 'Listar asistentes')
@section('content')
<main class="page registration-page" style="height: 100%;">
    <section class="clean-block clean-form dark" style="height: 100%;">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Listar asistentes</h2>
                <p>Lista de asistentes cargados en el sistema. Tiene la posibilidad de agregar un nuevo asistente.</p>

                <div class="d-flex justify-content-between align-items-center">
                    <form action="{{ route('assistants.index') }}" method="GET" class="col-sm-6" style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="searchText" placeholder="Buscar asistente" value="{{ $searchText }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                            </span>
                        </div>
                    </form>

                    @can('supervisor.create.employee')
                    <a class="btn btn-primary" href="{{route('employee.create')}}" role="button"><i class="fas fa-plus-circle"></i><span style="background-color: rgb(13, 110, 253);">Agregar
                            asistente</span></a>
                    @endcan
                </div>

                <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 15em;">Estado</th>
                                <th style="width: 45em;">Nombre y Apellido</th>
                                <th style="width: 25em;">CUIL</th>
                                <th style="padding-left: 4px;margin-left: 3px;width: 19em;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assistants as $assistant)
                            <tr>
                                <td>{{ $assistant->assistant_state }}</td>
                                <td><a>{{ $assistant->assistant_name }}
                                        {{ $assistant->assistant_last_name }}</a></td>
                                <td>{{ $assistant->assistant_cuil }}</td>

                                <td class="d-flex gap-3 justify-content-center">

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#Modal{{ $assistant->id }}">
                                        <i class="far fa-list-alt"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="Modal{{ $assistant->id }}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="ModalLabel">Detalles del
                                                        Asistente
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <table class="table">
                                                        <tr>
                                                            <td><strong>Nombre:</strong></td>
                                                            <td>{{ $assistant->assistant_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Apellido:</strong></td>
                                                            <td>{{ $assistant->assistant_last_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>CUIL:</strong></td>
                                                            <td>{{ $assistant->assistant_cuil }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Estado:</strong></td>
                                                            <td>{{ $assistant->assistant_state }}</td>
                                                        </tr>
                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin del Modal -->

                                    @can('assistant.edit')
                                    <a href="{{ route('assistants.edit', $assistant->id) }}" class="btn btn-warning"><i class="far fa-edit"></i></a>
                                    @endcan

                                    @can('assistant.destroy')
                                    <form action="{{ route('assistants.destroy', $assistant->id) }}" class="delete-record" method="POST" onsubmit="removalAlert(event, this);" style="display: inline;margin: 0;padding:0;border-top: none; background-color: transparent; box-shadow: none;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $assistants->links() }}
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