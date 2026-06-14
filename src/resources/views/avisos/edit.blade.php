@extends('layout')

@section('title', 'Editar Aviso')

@section('content')

    <div class="page-header">
        <h1>Editar Aviso <span style="color:var(--color-muted);font-weight:400;">#{{ $aviso->id }}</span></h1>
    </div>

    <div class="card">
        <form action="{{ route('avisos.update', $aviso) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="texto">Aviso</label>
                <textarea id="texto" name="texto" rows="3" required>{{ old('texto', $aviso->texto) }}</textarea>
            </div>

            <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <select id="prioridad" name="prioridad">
                    <option value="general"  {{ $aviso->prioridad === 'general'  ? 'selected' : '' }}>General</option>
                    <option value="urgente" {{ $aviso->prioridad === 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>

    <form action="{{ route('avisos.destroy', $aviso) }}" method="POST"
        onsubmit="return confirm('¿Eliminar este aviso?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i> Eliminar aviso</button>
    </form>

@endsection
