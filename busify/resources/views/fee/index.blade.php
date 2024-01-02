@extends('layouts.principal')
@section('title', 'Ingresar pago')
@section('content')
    <main class="page registration-page" style="height:100%;">
        <section class="clean-block clean-form dark" style="height:100%;">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Ingresar pago</h2>
                    <p>Selecciones las cuotas pendientes de su contrato que desee pagar</p>
                    <h3 class="text-start text-primary">Cuotas</h3>
                    
                        <form action="{{ route('payment.create') }}" method="post"
                            style="margin: 0;
                        width: 100%;
                        display: contents;">
                            @csrf
                            <div class="table-container" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:8em;">Mes/Año</th>
                                            <th style="width:7em;">Fecha de vencimiento</th>
                                            <th style="width:5em;">Monto</th>
                                            <th style="width:4em;">Pagar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fees as $fee)
                                            <tr>
                                                <td>{{date('d-m-Y', strtotime($fee->fee_expiration_date))}}</td>
                                                <td>{{$fee->fee_expiration_date}}</td>
                                                <td>${{number_format( $fee->fee_amount, 2)}}</td>
                                                <td>
                                                    <input class="chkbx-fee" type="checkbox" data-bs-toggle="tooltip"
                                                        data-bss-tooltip="" title="Seleccione para pagar esta cuota"
                                                        value="{{ $fee->id }}" name="selected_fees[]"
                                                        style="transform: scale(1.8); border-color: #007bff;border-width: 2px; transition: border-color 0.9s ease;">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>    

                    <div style="display:inline-flex;margin-bottom: 1em;"><button id = "btnSiguiente" class="btn btn-primary text-bg-primary"
                            type="submit"
                            style="background:rgb(25,135,84);margin-right:5em;border-style:none;">Siguiente</button>
                        </form>

                        <a href="{{route('home')}}" class="btn btn-primary" type="button"
                            style="background:rgb(220,53,69);border-style:none;">Cancelar</a>
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
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    </main>    
@endsection
