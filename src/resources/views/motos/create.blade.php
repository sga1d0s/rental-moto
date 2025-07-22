@extends('layout')

@section('title', 'Añadir Moto')

@section('content')
    <h1>➕ Añadir Motos</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('motos.store') }}" method="POST">
        @csrf

        <label for="modelo">Modelo:</label>
        <input id="modelo" name="modelo" value="{{ old('modelo') }}" required>

        <label for="matricula">Matrícula:</label>
        <input id="matricula" name="matricula" value="{{ old('matricula') }}" required>

        <label for="kilometros">Kilómetros:</label>
        <input id="kilometros" name="kilometros" type="number" value="{{ old('kilometros') }}" required>

        <label for="fecha_itv">Fecha ITV:</label>
        <input id="fecha_itv" name="fecha_itv" type="date" value="{{ old('fecha_itv') }}" required>

        <label for="status_id">Estado:</label>
        <select id="status_id" name="status_id" required>
            <option value="">-- Selecciona un estado --</option>
            @foreach ($statuses as $id => $name)
                <option value="{{ $id }}" {{ (int) old('status_id') === $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>

        <label for="ubicacion">Ubicación:</label>
        <input id="ubicacion" name="ubicacion" value="{{ old('ubicacion<') }}">

        <label for="comentarios">Comentarios:</label>
        <textarea id="comentarios" name="comentarios">{{ old('comentarios') }}</textarea>

        <button type="submit" class="primary">Guardar Moto</button>
    </form>
@endsection
