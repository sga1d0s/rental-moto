@extends('layout')

@section('title', 'Crear Reserva')

@section('content')
    <h1>➕ Crear Reserva</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservas.store') }}" method="POST">
        @csrf

        <label for="moto_id">Moto:</label>
        <select id="moto_id" name="moto_id">
            <option value="">— Sin moto —</option>
            @foreach ($motos as $id => $modelo)
                <option value="{{ $id }}" {{ old('moto_id') == $id ? 'selected' : '' }}>
                    {{ $modelo }}
                </option>
            @endforeach
        </select>

        <label for="cliente">Cliente:</label>
        <input id="cliente" name="cliente" type="text" value="{{ old('cliente') }}">

        <label for="fecha_desde">Reserva desde:</label>
        <input id="fecha_desde" name="fecha_desde" type="date" value="{{ old('fecha_desde') }}" required>

        <label for="fecha_hasta">Reserva hasta:</label>
        <input id="fecha_hasta" name="fecha_hasta" type="date" value="{{ old('fecha_hasta') }}" required>

        <button type="submit" class="primary">Guardar Reserva</button>
    </form>
@endsection
