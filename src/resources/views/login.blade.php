@extends('layout')

@section('title', 'Acceder')

@push('styles')
<style>
    body { padding-top: 0; padding-bottom: 0; }
</style>
@endpush

@section('content')
<div class="login-wrap">
    <div class="login-logo"><i class="bi bi-scooter"></i></div>
    <div class="login-app-name">RentalMoto</div>

    <div class="login-card">
        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:1.25rem;">Iniciar sesión</h2>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="tucorreo@ejemplo.com">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top:.75rem;">Entrar</button>
        </form>
    </div>
</div>
@endsection
