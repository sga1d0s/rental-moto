@extends('layout')

@section('title', 'Inicio')

@section('content')

    <div class="page-header">
        <h1>Avisos</h1>
        <a href="#" class="btn-add"><i class="bi bi-plus-lg"></i> Nuevo</a>
    </div>

    {{-- Urgentes --}}
    <p class="section-title" style="color:var(--color-danger);">
        <i class="bi bi-exclamation-circle"></i> Urgentes
    </p>

    @forelse($urgentes as $aviso)
        <div class="aviso-card aviso-card--urgente">
            <div class="aviso-card__text">{{ $aviso->texto }}</div>
            <button class="aviso-card__check" title="Marcar como resuelto">
                <i class="bi bi-check-lg"></i>
            </button>
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
            <div class="aviso-card__text">{{ $aviso->texto }}</div>
            <button class="aviso-card__check" title="Marcar como resuelto">
                <i class="bi bi-check-lg"></i>
            </button>
        </div>
    @empty
        <p class="empty-state">Sin avisos generales</p>
    @endforelse

@endsection
