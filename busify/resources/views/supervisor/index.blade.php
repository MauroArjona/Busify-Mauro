@extends('layouts.principal')
@section('title', 'Listar supervisores')
@section('content')
<main class="page registration-page" style="height: 100%;">
    <section class="clean-block clean-form dark" style="height: 100%;">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Listar supervisores</h2>

                <div class="d-flex justify-content-between">
                    <form id="search-form" action="{{ route('supervisor.list-supervisors') }}" method="GET" class="col-sm-6" style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Buscar supervisores">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                            </span>
                        </div>
                    </form>

                    <div class="d-flex justify-content-center align-items-center">
                        <a class="btn btn-primary " role="button" href="{{ route('supervisor.create') }}"><i class="fas fa-plus-circle"></i><span style="background-color:rgb(13, 110, 253);">Agregar
                                supervisor</span></a>
                    </div>
                </div>
                <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 25em;">CUIL</th>
                                <th style="width: 45em;">Nombre y Apellido</th>
                                <th style="width: 15em;">Número de teléfono</th>
                                <th style="padding-left: 4px;margin-left: 3px;width: 24em;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supervisors as $supervisor)
                            <tr>
                                <td>{{ $supervisor->supervisor_cuil }}</td>
                                <td>{{ $supervisor->user->name }} {{ $supervisor->user->lastName }}</td>
                                <td>{{ $supervisor->user->phoneNumber }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('supervisor.show', $supervisor->id) }}" class="btn btn-info" type="button" style="margin-right: 13px;"><i class="far fa-list-alt"></i>Detalles</a>
                                    <a href="{{ route('supervisor.edit', $supervisor->id) }}" class="btn btn-warning"><i class="far fa-edit"></i></a>
                                    <form action="{{ route('supervisor.destroy', $supervisor->id) }}" class="delete-record" method="POST" onsubmit="removalAlert(event,this);" style="display: inline; margin: 0; padding: 0; border-top: none; background-color: transparent; box-shadow: none;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" style="margin-right: 13px;"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $supervisors->links() }}
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