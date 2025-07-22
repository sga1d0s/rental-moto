@extends('layout')

@section('title', 'Listado de Reservas')

@section('content')
    <h1 class="mb-4">Reservas</h1>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <a href="{{ route('reservas.create') }}">➕ Nueva Reserva</a>
        <strong style="color: red;">
            {{ now()->format('d-m-Y') }}
        </strong>
    </div>

    {{-- BLOQUE 1: Reservas SIN moto --}}
    <h2 class="text-lg font-semibold mt-6 mb-2 text-red-600">🚫 Sin Moto Asignada</h2>
    <table class="table-auto w-full border-collapse mb-6">
        <thead>
            <tr>
                <th></th>
                <th>Cliente</th>
                <th>Desde</th>
                <th>Hasta</th>
            </tr>
        </thead>
        <tbody>
            @php $haySinMoto = false; @endphp
            @foreach($reservasSinMoto as $res)
                @if($res->fecha_hasta->lt(now()))
                    @continue
                @endif
                @php $haySinMoto = true; @endphp
                <tr>
                    <td>
                        <a href="{{ route('reservas.edit', $res) }}">✏️</a>
                    </td>
                    <td>{{ $res->cliente ?? '— sin cliente —' }}</td>
                    <td>{{ $res->fecha_desde->format('d-m') }}</td>
                    <td>{{ $res->fecha_hasta->format('d-m') }}</td>
                </tr>
            @endforeach
            @unless($haySinMoto)
                <tr>
                    <td colspan="4">No hay reservas sin moto</td>
                </tr>
            @endunless
        </tbody>
    </table>

    {{-- BLOQUE 2: Reservas CON moto --}}
    <h2 class="text-lg font-semibold mb-2 text-green-600 flex items-center justify-between">
        🏍️ Con Moto Asignada
        <button onclick="toggleConMoto()" class="text-sm bg-gray-200 px-2 py-1 rounded">
            🔽 Mostrar/Ocultar
        </button>
    </h2>

    <div id="conMotoBlock">
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
                @php $hayConMoto = false; @endphp
                @foreach($reservasConMoto as $res)
                    @if($res->fecha_hasta->lt(now()))
                        @continue
                    @endif
                    @php $hayConMoto = true; @endphp
                    <tr>
                        <td>
                            <a href="{{ route('reservas.edit', $res) }}">✏️</a>
                        </td>
                        <td>
                            <div>{{ $res->cliente ?? '— sin cliente —' }}</div>
                            <div class="text-sm text-gray-600">{{ $res->moto?->modelo ?? '' }}</div>
                        </td>
                        <td>{{ $res->fecha_desde->format('d-m') }}</td>
                        <td>{{ $res->fecha_hasta->format('d-m') }}</td>
                    </tr>
                @endforeach
                @unless($hayConMoto)
                    <tr>
                        <td colspan="4">No hay reservas con moto</td>
                    </tr>
                @endunless
            </tbody>
        </table>
    </div>
@endsection

<script>
    function toggleConMoto() {
        const block = document.getElementById('conMotoBlock');
        block.style.display = block.style.display === 'none' ? 'block' : 'none';
    }
</script>