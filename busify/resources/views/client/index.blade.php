@extends('layouts.principal')
@section('title', 'Listar clientes')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Listar clientes</h2>
                    <p>Lista de clientes cargados en el sistema</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('client.index') }}" method="GET" class="col-sm-6"
                            style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText" placeholder="Buscar cliente"
                                    value="{{ $searchText }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 1em">Buscar</button>
                                </span>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 45em;">Nombre y Apellido</th>
                                    <th style="width: 25em;">CUIL</th>
                                    <th style="width: 25em;">Telefono</th>
                                    <th style="width: 25em;">Email</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 19em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->user->name }} {{ $client->user->lastName }}</td>
                                        <td>{{ $client->client_cuil }}</td>
                                        <td>{{ $client->user->phoneNumber }}</td>
                                        <td>{{ $client->user->email }}</td>
                                        <td>
                                            <a target="_blank" href="{{ route('client.show', $client->id) }}" class="btn btn-info"
                                            type="button" style="margin-right: 13px;"><i
                                                class="far fa-list-alt"></i>Detalles</a>     
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $clients->links() }}
                </div>   
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
