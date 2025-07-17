@extends('layout')

@section('title', 'Iniciar sesión')

@section('content')
  <h1>Login de Usuarios</h1>

  @if(session('error'))
    <div style="color:red; margin-bottom:1rem;">
      {{ session('error') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <label for="email">Email:</label>
    <input 
      id="email" 
      type="email" 
      name="email" 
      value="{{ old('email') }}" 
      required 
      placeholder="tucorreo@ejemplo.com"
    >

    <label for="password">Contraseña:</label>
    <input 
      id="password" 
      type="password" 
      name="password" 
      required 
      placeholder="••••••••"
    >

    <button type="submit" class="primary">Iniciar sesión</button>
  </form>
@endsection