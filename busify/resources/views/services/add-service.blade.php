@extends('layouts.principal')
@section('title', 'Agregar servicio')
@section('content')
    <main class="page registration-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Agregar servicio</h2>
                    <p>Complete los datos solicitados para agregar un servicio al contrato.</p>
                </div>
                <form>
                    <h3>Servicio</h3>
                    <div class="mb-3"><label class="form-label" for="name">Tipo de servicio</label>
                        <div class="dropdown"><button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">Seleccione...</button>
                            <div class="dropdown-menu"><a class="dropdown-item" href="#">Semicompleto</a><a class="dropdown-item" href="#">Completo</a></div>
                        </div>
                    </div>
                    <div class="mb-3"><label class="form-label" for="password">Nombre de pasajero</label><input class="form-control" type="text"></div>
                    <div class="mb-3"><label class="form-label" for="email">Hora de retiro</label><input class="form-control" type="text"></div>
                    <div class="mb-3"><label class="form-label" for="email">Hora de entrega</label><input class="form-control" type="text"></div>
                    <div class="mb-3"><label class="form-label" for="email">Dirección de origen</label><input class="form-control" type="text"></div>
                    <div class="mb-3"><label class="form-label" for="email">Dirección de establecimiento escolar</label><input class="form-control" type="text"></div>
                    <div class="mb-3"><label class="form-label" for="email">Distancia aproximada (km)</label><input class="form-control" type="number"></div>
                    <div class="d-flex flex-row justify-content-between justify-content-xl-center"><button class="btn btn-success d-xl-flex mx-auto" type="submit">Agregar</button><button class="btn btn-danger d-xl-flex mx-auto" type="button">Cancelar</button></div>
                </form>
            </div>
        </section>
    </main>
@endsection