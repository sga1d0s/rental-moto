@extends('layout')

@section('title', 'Editar Moto')

@section('content')

    <div class="page-header">
        <h1>Editar Moto <span style="color:var(--color-muted);font-weight:400;">#{{ $moto->id }}</span></h1>
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
        <form action="{{ route('motos.update', $moto) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input id="modelo" name="modelo" value="{{ old('modelo', $moto->modelo) }}" required>
            </div>

            <div class="form-group">
                <label for="matricula">Matrícula</label>
                <input id="matricula" name="matricula" value="{{ old('matricula', $moto->matricula) }}" required>
            </div>

            <div class="form-group">
                <label for="kilometros">Kilómetros</label>
                <input id="kilometros" name="kilometros" type="number" value="{{ old('kilometros', $moto->kilometros) }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_itv">Fecha ITV</label>
                <input id="fecha_itv" name="fecha_itv" type="date"
                    value="{{ old('fecha_itv', $moto->fecha_itv->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="status_id">Estado</label>
                <select id="status_id" name="status_id" required>
                    @foreach ($statuses as $id => $name)
                        <option value="{{ $id }}" {{ (int) old('status_id', $moto->status_id) === $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ubicacion">Ubicación</label>
                <input id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $moto->ubicacion ?? '') }}" placeholder="Ej: Nave principal">
            </div>

            <div class="form-group">
                <label for="comentarios">Comentarios</label>
                <textarea id="comentarios" name="comentarios" placeholder="Notas adicionales…">{{ old('comentarios', $moto->comentarios) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Moto</button>
        </form>
    </div>

    <form action="{{ route('motos.destroy', $moto) }}" method="POST"
        onsubmit="return confirm('¿Eliminar esta moto?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑 Eliminar moto</button>
    </form>

@endsection
