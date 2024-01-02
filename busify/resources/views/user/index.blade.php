@extends('layouts.principal')
@section('title', 'Perfil')
@section('content')
    <main class="page pricing-table-page" style="height: 100%;">
        <section class="clean-block clean-pricing dark w-full" style="height: 100%;">
            <h1 class="text-center" style="padding: 2%; font-weight:600; font-size:30px;">Mi perfil</h1>

            <div class="container mb-8">
                <div class="row justify-content-center gap-4">
                    <div class="col-md-8 col-lg-10">
                        <br>
                        <div class="clean-pricing-item">
                            <div class="heading">
                                <h3>Información del Perfil</h3>
                            </div>
                            @php
                                try {
                                    if (Session::has('error')) {
                                        throw new Exception(Session::get('error'));
                                    }
                                } catch (Exception $e) {
                                    echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
                                }

                                try {
                                    if (Session::has('success')) {
                                        throw new Exception(Session::get('success'));
                                    }
                                } catch (Exception $e) {
                                    echo '<div class="alert alert-success">' . $e->getMessage() . '</div>';
                                }
                            @endphp
                            <div class="features">
                                <div class="container features">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-justify">Información personal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="feature">Nombre:</span></td>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><span class="feature">Apellido:</span></td>
                                                <td>{{ $user->lastName }}</td>
                                            </tr>
                                            <tr>
                                                <td><span class="feature">DNI:</span></td>
                                                <td>{{ $user->dni }}</td>
                                            </tr>
                                            <tr>
                                                <td><span class="feature">Teléfono:</span></td>
                                                <td>{{ $user->phoneNumber }}</td>
                                            </tr>
                                            <tr>
                                                <td><span class="feature">Fecha de nacimiento:</span></td>
                                                <td>{{ $user->birthdate }}</td>
                                            </tr>
                                            <tr>
                                                <td><span class="feature">Domicilio:</span></td>
                                                <td>{{ $user->address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table">
                                        <tr>
                                            <th>Información de la Cuenta</th>
                                        </tr>
                                        <tbody class="text-start">
                                            <tr>
                                                <td>
                                                    <span class="feature">Email:&nbsp;</span>
                                                </td>
                                                <td>
                                                    {{ $user->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="feature">Contraseña:&nbsp;</span>
                                                </td>
                                                <td>
                                                    <span>********</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @can('user.edit')
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6 text-center">
                                            <a href="{{ route('user.edit', $user->id) }}" type="button" id="editar-btn"
                                                class="btn btn-primary btn-m d-md-block w-100 ">Editar</a>
                                        </div>
                                        @if ($user->userable_type == 'App\Models\Client')
                                            <div class="col-md-6 text-center">
                                                <form action="{{ route('client.desactivate', $user->userable_id) }}"
                                                    method="POST" onsubmit="removalAlert(event, this)">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-m d-md-block w-100 "
                                                        id="eliminar-btn">Eliminar cuenta</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endcan

                        </div>

                    </div>

                </div>
            </div>
            <br>
        </section>
    </main>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endsection
