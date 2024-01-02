@extends('layouts.principal')
@section('title', 'Listar choferes')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Listar choferes</h2>
                    <p>Lista de choferes cargados en el sistema. Tiene la posibilidad de agregar un nuevo chofer.</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('driver.index') }}" method="GET" class="col-sm-6"
                            style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText" placeholder="Buscar chofer"
                                    value="{{ $searchText }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                                </span>
                            </div>
                        </form>

                        @can('supervisor.create.employee')
                            <h3 class="text-start text-primary"><a class="btn btn-primary float-end" role="button"
                                    href="{{ route('employee.create') }}"><i class="fas fa-plus-circle"></i><span
                                        style="background-color:rgb(13, 110, 253);">Agregar chofer</span></a></h3>
                        @endcan
                    </div>
                    <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;width: 81em">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15em;">Estado</th>
                                    <th style="width: 45em;">Nombre y Apellido</th>
                                    <th style="width: 25em;">CUIL</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 24em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $driver)
                                    <tr>
                                        <td>{{ $driver->driver_state }}</td>
                                        <td>{{ $driver->user->name }} {{ $driver->user->lastName }}</td>
                                        <td>{{ $driver->driver_cuil }}</td>

                                        <td class="d-flex gap-3 justify-content-center">
                                            @can('driver.show')
                                                <a target="_blank" href="{{ route('driver.show', $driver->id) }}"
                                                    class="btn btn-info" type="button"><i class="far fa-list-alt"></i></a>
                                            @endcan
                                            @can('driver.giveRest')
                                                @if ($driver->driver_state == 'DISPONIBLE' || $driver->driver_state == 'ASIGNADO')
                                                    <form action="{{ route('driver.giveRest', $driver->id) }}"
                                                        class="delete-record" method="POST" onsubmit="giveRest(event, this);"
                                                        style="display: inline; margin: 0; padding: 0; border-top: none; background-color: transparent; box-shadow: none;">
                                                        @csrf
                                                        <button class="btn btn-success" type="submit"><i
                                                                class="fas fa-user-check"></i></button>
                                                    </form>
                                                @endif
                                            @endcan
                                            @can('driver.enable')
                                                @if ($driver->driver_state == 'DESCANSO')
                                                    <form action="{{ route('driver.enable', $driver->id) }}"
                                                        class="delete-record" method="POST"
                                                        onsubmit="driverEnable(event, this);"
                                                        style="display: inline; margin: 0; padding: 0; border-top: none; background-color: transparent; box-shadow: none;">
                                                        @csrf
                                                        <button class="btn btn-secondary" type="submit"><i
                                                                class="fas fa-user-lock"></i></button>
                                                    </form>
                                                @endif
                                            @endcan
                                            @can('driver.edit')
                                                <a href="{{ route('driver.edit', $driver->id) }}" class="btn btn-warning"><i
                                                        class="far fa-edit"></i></a>
                                            @endcan
                                            @can('driver.destroy')
                                                <form action="{{ route('driver.destroy', $driver->id) }}" class="delete-record"
                                                    method="POST" onsubmit="removalAlert(event, this);"
                                                    style="display: inline; margin: 0; padding: 0; border-top: none; background-color: transparent; box-shadow: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit"><i
                                                            class="far fa-trash-alt"></i></button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $drivers->links() }}
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
