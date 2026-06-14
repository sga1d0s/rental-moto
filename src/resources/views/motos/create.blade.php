@extends('layout')

@section('title', 'Añadir Moto')

@section('content')

    <div class="page-header">
        <h1>Nueva Moto</h1>
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
        <form action="{{ route('motos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input id="modelo" name="modelo" value="{{ old('modelo') }}" required placeholder="Ej: Honda CB500">
            </div>

            <div class="form-group">
                <label for="matricula">Matrícula</label>
                <input id="matricula" name="matricula" value="{{ old('matricula') }}" required placeholder="Ej: 1234 ABC">
            </div>

            <div class="form-group">
                <label for="kilometros">Kilómetros</label>
                <input id="kilometros" name="kilometros" type="number" value="{{ old('kilometros') }}" required placeholder="0">
            </div>

            <div class="form-group">
                <label for="fecha_itv">Fecha ITV</label>
                <input id="fecha_itv" name="fecha_itv" type="date" value="{{ old('fecha_itv') }}" required>
            </div>

            <div class="form-group">
                <label for="status_id">Estado</label>
                <select id="status_id" name="status_id" required>
                    <option value="">— Selecciona un estado —</option>
                    @foreach ($statuses as $id => $name)
                        <option value="{{ $id }}" {{ (int) old('status_id') === $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ubicacion">Ubicación</label>
                <input id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" placeholder="Ej: Nave principal">
            </div>

            <div class="form-group">
                <label for="comentarios">Comentarios</label>
                <textarea id="comentarios" name="comentarios" placeholder="Notas adicionales…">{{ old('comentarios') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Moto</button>
        </form>
    </div>

@endsection
