@extends('layout')

@section('title', 'Editar Moto')

@section('content')
    <h1>Editar Moto nº{{ $moto->id }}</h1>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('motos.update', $moto) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="modelo">Modelo:</label>
        <input id="modelo" name="modelo" value="{{ old('modelo', $moto->modelo) }}" required>

        <label for="matricula">Matrícula:</label>
        <input id="matricula" name="matricula" value="{{ old('matricula', $moto->matricula) }}" required>

        <label for="kilometros">Kilómetros:</label>
        <input id="kilometros" name="kilometros" type="number" value="{{ old('kilometros', $moto->kilometros) }}" required>

        <label for="fecha_itv">Fecha ITV:</label>
        <input id="fecha_itv" name="fecha_itv" type="date"
            value="{{ old('fecha_itv', $moto->fecha_itv->format('Y-m-d')) }}" required>

        <label for="status_id">Estado:</label>
        <select id="status_id" name="status_id" required>
            @foreach ($statuses as $id => $name)
                <option value="{{ $id }}"
                    {{ (int) old('status_id', $moto->status_id) === $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>

        <label for="comentarios">Comentarios:</label>
        <textarea id="comentarios" name="comentarios">{{ old('comentarios', $moto->comentarios) }}</textarea>

        <button type="submit" class="primary">Actualizar Moto</button>
    </form>

    <form action="{{ route('motos.destroy', $moto) }}" method="POST" onsubmit="return confirm('¿Eliminar esta moto?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete">Eliminar Moto</button>
    </form>
@endsection
