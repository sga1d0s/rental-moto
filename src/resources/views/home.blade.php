@extends('layout')

@section('title', 'Inicio')

@section('content')

    <div class="page-header">
        <h1>Avisos</h1>
        <button class="btn-add" onclick="toggleNuevoAviso()">
            <i class="bi bi-plus-lg"></i> Nuevo
        </button>
    </div>

    {{-- Formulario nuevo aviso (oculto por defecto) --}}
    <div id="nuevo-aviso-form" style="display:none; margin-bottom:1rem;">
        <div class="card">
            <form action="{{ route('avisos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="texto">Aviso</label>
                    <textarea id="texto" name="texto" rows="2" placeholder="Escribe el aviso…" required></textarea>
                </div>
                <div class="form-group">
                    <label for="prioridad">Prioridad</label>
                    <select id="prioridad" name="prioridad">
                        <option value="general">General</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    {{-- Urgentes --}}
    <p class="section-title" style="color:var(--color-danger);">
        <i class="bi bi-exclamation-circle"></i> Urgentes
    </p>

    @forelse($urgentes as $aviso)
        <div class="aviso-card aviso-card--urgente">
            <a href="{{ route('avisos.edit', $aviso) }}" class="aviso-card__edit"><i class="bi bi-pencil"></i></a>
            <div class="aviso-card__text">{{ $aviso->texto }}</div>
            <form action="{{ route('avisos.completar', $aviso) }}" method="POST" style="margin:0;">
                @csrf @method('PATCH')
                <button type="submit" class="aviso-card__check" title="Marcar como resuelto">
                    <i class="bi bi-check-lg"></i>
                </button>
            </form>
        </div>
    @empty
        <p class="empty-state">Sin avisos urgentes</p>
    @endforelse

    {{-- Generales --}}
    <p class="section-title" style="margin-top:1.25rem;">
        <i class="bi bi-bell"></i> General
    </p>

    @forelse($generales as $aviso)
        <div class="aviso-card">
            <a href="{{ route('avisos.edit', $aviso) }}" class="aviso-card__edit"><i class="bi bi-pencil"></i></a>
            <div class="aviso-card__text">{{ $aviso->texto }}</div>
            <form action="{{ route('avisos.completar', $aviso) }}" method="POST" style="margin:0;">
                @csrf @method('PATCH')
                <button type="submit" class="aviso-card__check" title="Marcar como resuelto">
                    <i class="bi bi-check-lg"></i>
                </button>
            </form>
        </div>
    @empty
        <p class="empty-state">Sin avisos generales</p>
    @endforelse

    {{-- Historial --}}
    <button class="historial-toggle" onclick="toggleHistorial()">
        <span><i class="bi bi-clock-history"></i> Historial</span>
        @if($historial->count())
            <span class="historial-badge">{{ $historial->count() }}</span>
        @endif
        <i class="bi bi-chevron-down historial-chevron" id="historial-chevron"></i>
    </button>

    <div id="historial-block" style="display:none;">
        @forelse($historial as $aviso)
            <div class="aviso-card aviso-card--done">
                <a href="{{ route('avisos.edit', $aviso) }}" class="aviso-card__edit"><i class="bi bi-pencil"></i></a>
                <div class="aviso-card__text">{{ $aviso->texto }}</div>
                <form action="{{ route('avisos.desmarcar', $aviso) }}" method="POST" style="margin:0;">
                    @csrf @method('PATCH')
                    <button type="submit" class="aviso-card__uncheck" title="Desmarcar">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </form>
            </div>
        @empty
            <p class="empty-state">Sin avisos completados</p>
        @endforelse
    </div>

@endsection

@push('scripts')
<script>
    function toggleNuevoAviso() {
        const form = document.getElementById('nuevo-aviso-form');
        form.style.display = form.style.display === 'none' ? '' : 'none';
    }

    function toggleHistorial() {
        const block   = document.getElementById('historial-block');
        const chevron = document.getElementById('historial-chevron');
        const open    = block.style.display === 'none';
        block.style.display   = open ? '' : 'none';
        chevron.style.transform = open ? 'rotate(180deg)' : '';
    }
</script>
@endpush
