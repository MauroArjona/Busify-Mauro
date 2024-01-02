@extends('layouts.principal')
@section('title', 'Lista contratos')
@section('content')
    <main class="page registration-page" style="height:100%;">
        <section class="clean-block clean-form dark" style="height:100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Historial de contratos</h2>
                    <p>Lista de contratos realizados con la empresa</p>
                    <h3 class="text-start text-primary">Contratos</h3>
                    <div class="table-responsive d-flex mx-auto" style="margin-top:0px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:9em;">Precio mensual</th>
                                    <th style="width:8em;">Fecha de inicio</th>
                                    <th style="width:8em;">Fecha de finalización</th>
                                    <th style="width:10em;">Cantidad de servicios</th>
                                    <th style="width:10em;">Estado</th>
                                    <th style="padding-left:4px;margin-left:3px;width:6em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contracts as $contract)
                                <tr>
                                    <td>${{number_format($contract->contract_montly_fee, 2, ',', '.')}}</td>                                   
                                    <td>{{date('d-m-Y', strtotime($contract->contract_start_date))}}</td>
                                    <td>{{date('d-m-Y', strtotime($contract->contract_end_date))}}</td>
                                    <td>{{$contract->services()->count()}}</td>
                                    <td>{{str_replace('_', ' ', $contract->contract_state)}}</td>
                                    <td>
                                        <a target="_blank" href="{{route('contract.show', $contract->id)}}" class="btn btn-info" type="button"
                                            style="margin-right: 13px;"><i class="far fa-list-alt"></i>Detalles</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection