@extends('layouts.principal')
@section('title', 'Mis pagos')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Mis pagos</h2>
                    <p>Lista de mis pagos cargados en el sistema</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('payment.index') }}" method="GET" class="col-sm-6"
                            style="background: transparent; border: none; box-shadow: none; padding-left: 0; margin: 0;">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText" placeholder="Buscar pago"
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
                                    <th style="width: 7em;">Monto</th>
                                    <th style="width: 25em;">Fecha de pago</th>
                                    <th style="width: 7em;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $client)
                                    @foreach ($client->contracts as $contract)
                                        @isset($contract->currentAccount->fees)
                                            @foreach ($contract->currentAccount->fees as $fee)
                                                @if ($fee->fee_state == 'PAGA')
                                                    @if ($searchText && (strpos($fee->payment->payment_amount, $searchText) !== false || strpos($fee->payment->payment_date, $searchText) !== false))
                                                        <tr>
                                                            <td>${{ $fee->payment->payment_amount }}</td>
                                                            <td>{{ $fee->payment->payment_date }}</td>
                                                            <td>{{ $fee->fee_state }}</td>
                                                        </tr>
                                                    @elseif (!$searchText)
                                                        <tr>
                                                            <td>${{ $fee->payment->payment_amount }}</td>
                                                            <td>{{ $fee->payment->payment_date }}</td>
                                                            <td>{{ $fee->fee_state }}</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endisset
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="3">No se encontraron pagos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $payments->links() }}
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
            </div>
        </section>
    </main>
@endsection
