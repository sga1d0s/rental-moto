@extends('layout')

@section('title', 'Editar Reserva')

@section('content')

    <div class="page-header">
        <h1>Editar Reserva <span style="color:var(--color-muted);font-weight:400;">#{{ $reserva->id }}</span></h1>
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
        <form action="{{ route('reservas.update', $reserva) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="moto_id">Moto</label>
                <select id="moto_id" name="moto_id">
                    <option value="" {{ old('moto_id', $reserva->moto_id) === null ? 'selected' : '' }}>— Sin moto —</option>
                    @foreach ($motos as $id => $modelo)
                        <option value="{{ $id }}" {{ old('moto_id', $reserva->moto_id) == $id ? 'selected' : '' }}>{{ $modelo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cliente">Cliente</label>
                <input id="cliente" name="cliente" type="text" value="{{ old('cliente', $reserva->cliente) }}" placeholder="Nombre del cliente">
            </div>

            <div class="form-group">
                <label for="fecha_desde">Desde</label>
                <input id="fecha_desde" name="fecha_desde" type="date"
                    value="{{ old('fecha_desde', optional($reserva->fecha_desde)->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_hasta">Hasta</label>
                <input id="fecha_hasta" name="fecha_hasta" type="date"
                    value="{{ old('fecha_hasta', optional($reserva->fecha_hasta)->format('Y-m-d')) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
        </form>
    </div>

    <form action="{{ route('reservas.destroy', $reserva) }}" method="POST"
        onsubmit="return confirm('¿Eliminar esta reserva?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i> Eliminar reserva</button>
    </form>

@endsection
