@extends('layouts.principal')
@section('title', 'Lista itinerario')
@section('content')
    <main class="page registration-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Lista de Precios</h2>
                    <p>Lista de precios cargados en el sistema.</p>


                    <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15em;">Tipo de servicio</th>
                                    <th style="width: 13em;">Precio por km</th>
                                    <th style="width: 15em;">Descuento</th>
                                    <th style="padding-left: 4px;margin-left: 3px;width: 6em;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($prices as $price)
                                    <tr>
                                        <td>{{ str_replace('eSrv', 'o', class_basename($price->service_type)) }}</td>
                                        <td>${{ $price->price_per_km }}</td>
                                        <td>{{ $price->discount_per_aditional_passenger}} %</td>
                                        <td>
                                            <a href="{{ route('price.edit', $price->id) }}" class="btn btn-warning"
                                                type="button" style="margin-right: 13px;"><i class="far fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
            </div>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
