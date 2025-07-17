@extends('layout')

@section('title', 'Listado de Reservas')

@section('content')
    <h1 class="mb-4">Reservas</h1>
    <p><a href="{{ route('reservas.create') }}">➕ Nueva Reserva</a></p>

    <table class="table-auto w-full border-collapse">
        <thead>
            <tr>
                <th></th>
                <th>Cliente / Moto</th>
                <th>Desde</th>
                <th>Hasta</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservas as $res)
                <tr>
                    <td>
                        <a href="{{ route('reservas.edit', $res) }}">✏️</a>
                    </td>
                    <td>
                        {{-- Nombre del cliente --}}
                        <div>
                            {{ $res->cliente ?? '— sin cliente —' }}
                        </div>
                        {{-- Modelo de la moto, si existe relación --}}
                        <div class="text-sm text-gray-600">
                            {{ $res->moto?->modelo ?? '— sin moto —' }}
                        </div>
                    </td>
                    <td>{{ $res->fecha_desde->format('d-m') }}</td>
                    <td>{{ $res->fecha_hasta->format('d-m') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay reservas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection