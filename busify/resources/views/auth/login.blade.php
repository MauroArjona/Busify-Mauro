@extends('layouts.principal')
@section('title', 'Iniciar sesión')
@section('content')
    <main class="page login-page" style="height: 100%;">
        <section class="clean-block clean-form dark" style="height: 100%;">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Iniciar sesión</h2>
                    <p>Ingrese sus datos de usuario para poder iniciar sesión en Busify.</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3"><label class="form-label" for="email">Email</label><input
                            class="form-control item" type="email" name="email" id="email-id" data-bs-theme="light">
                    </div>
                    <div class="mb-3"><label class="form-label" for="password">Contraseña</label><input
                            class="form-control" type="password" name="password" id="password-id" data-bs-theme="light">
                    </div>
                    <div class="mb-3">
                        <div class="form-check"><input class="form-check-input" type="checkbox" name="remember"
                                id="checkbox" data-bs-theme="light"><label class="form-check-label"
                                for="checkbox">Recordarme</label>
                        </div>
                    </div><button class="btn btn-primary" type="submit">Iniciar sesión</button>
                </form>
            </div>
        </section>
    </main>
@endsection
