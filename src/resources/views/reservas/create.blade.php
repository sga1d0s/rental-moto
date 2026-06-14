@extends('layout')

@section('title', 'Nueva Reserva')

@section('content')

    <div class="page-header">
        <h1>Nueva Reserva</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:1.2rem;">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('reservas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="moto_id">Moto</label>
                <select id="moto_id" name="moto_id">
                    <option value="">— Sin moto —</option>
                    @foreach ($motos as $id => $modelo)
                        <option value="{{ $id }}" {{ old('moto_id') == $id ? 'selected' : '' }}>{{ $modelo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cliente">Cliente</label>
                <input id="cliente" name="cliente" type="text" value="{{ old('cliente') }}" placeholder="Nombre del cliente">
            </div>

            <div class="form-group">
                <label for="fecha_desde">Desde</label>
                <input id="fecha_desde" name="fecha_desde" type="date" value="{{ old('fecha_desde') }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_hasta">Hasta</label>
                <input id="fecha_hasta" name="fecha_hasta" type="date" value="{{ old('fecha_hasta') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Reserva</button>
        </form>
    </div>

@endsection
