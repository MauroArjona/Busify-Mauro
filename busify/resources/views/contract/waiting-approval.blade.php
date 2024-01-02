@extends('layouts.principal')
@section('title', 'Contratos habilitados')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Contratos esperando aprobación</h2>
                    <p>Lista de contratos esperando aprobación.</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('contract.waitingApproval') }}" method="GET" class="col-sm-6"
                            style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText" placeholder="Buscar contrato"
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
                                    <th style="width: 15em;">Fecha de inicio</th>
                                    <th style="width: 13em;">Fecha de fin</th>
                                    <th style="width: 15em;">Monto de cuota</th>
                                    <th style="width: 15em;">Estado</th>
                                    <th style="width: 15em;">Cliente</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 20em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($contracts as $contract)
                                    <tr>
                                        <td>{{ $contract->contract_start_date }}</td>
                                        <td>{{ $contract->contract_end_date ? $contract->contract_end_date : 'Sin especificar' }}
                                        </td>
                                        <td>${{number_format($contract->contract_montly_fee, 2, ',', '.')}}</td>   
                                        @if ($contract->contract_state == 'ESPERANDO_APROBACION')
                                            <td>ESPERANDO APROBACIÓN</td>
                                        @endif
                                        <td><a target="_blank" href="{{ route('client.show', $contract->client->id) }}"><i
                                                    class="fas fa-info-circle"></i>{{ $contract->client->user->name . ' ' . $contract->client->user->lastName }}
                                        </td>
                                        <td>
                                            <form title="Aprobar contrato"
                                                action="{{ route('contract.approve', $contract->id) }}" class="save-record"
                                                method="POST" onsubmit="acceptContract(event, this);"
                                                style="display: inline;margin: 0;padding:0;border-top: none; background-color: transparent; box-shadow: none;">
                                                @csrf
                                                <button class="btn btn-success" type="submit"><i
                                                        class="far fa-handshake"></i>Aprobar</button>
                                            </form>
                                            <form title="Rechazar contrato"
                                                action="{{ route('contract.reject', $contract->id) }}" class="save-record"
                                                method="POST" onsubmit="rejectContract(event, this);"
                                                style="display: inline;margin: 0;padding:0;border-top: none; background-color: transparent; box-shadow: none;">
                                                @csrf
                                                <button class="btn btn-danger" type="submit"><i
                                                        class="far fa-times-circle"></i></button>
                                            </form>
                                            <a target="_blank" href="{{ route('contract.show', $contract->id) }}"
                                                href="" class="btn btn-info" type="button"><i
                                                    class="far fa-list-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    {{ $contracts->links() }}
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
