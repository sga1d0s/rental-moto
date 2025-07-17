@extends('layout')

@section('title', 'Editar Reserva')

@section('content')
    <h1>✏️ Editar Reserva nº{{ $reserva->id }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservas.update', $reserva) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="moto_id">Moto:</label>
        <select id="moto_id" name="moto_id">
            <option value="" {{ old('moto_id', $reserva->moto_id) === null ? 'selected' : '' }}>
                — Sin moto —
            </option>
            @foreach ($motos as $id => $modelo)
                <option
                    value="{{ $id }}"
                    {{ old('moto_id', $reserva->moto_id) == $id ? 'selected' : '' }}
                >
                    {{ $modelo }}
                </option>
            @endforeach
        </select>

        <label for="cliente">Cliente:</label>
        <input
            id="cliente"
            name="cliente"
            type="text"
            value="{{ old('cliente', $reserva->cliente) }}"
        >

        <label for="fecha_desde">Reserva desde:</label>
        <input
            id="fecha_desde"
            name="fecha_desde"
            type="date"
            value="{{ old('fecha_desde', optional($reserva->fecha_desde)->format('Y-m-d')) }}"
            required
        >

        <label for="fecha_hasta">Reserva hasta:</label>
        <input
            id="fecha_hasta"
            name="fecha_hasta"
            type="date"
            value="{{ old('fecha_hasta', optional($reserva->fecha_hasta)->format('Y-m-d')) }}"
            required
        >

        <button type="submit" class="primary">Actualizar Reserva</button>
    </form>

    <form
        action="{{ route('reservas.destroy', $reserva) }}"
        method="POST"
        onsubmit="return confirm('¿Eliminar esta reserva?')"
    >
        @csrf
        @method('DELETE')
        <button class="delete" type="submit">🗑️ Eliminar</button>
    </form>
@endsection