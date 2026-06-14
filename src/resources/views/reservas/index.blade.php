@extends('layout')

@section('title', 'Reservas')

@section('content')

    <div class="page-header">
        <h1>Reservas</h1>
        <a href="{{ route('reservas.create') }}" class="btn-add">＋ Nueva</a>
    </div>

    {{-- Sin moto asignada --}}
    <div class="card" style="padding:.75rem 1rem;">
        <div class="section-header">
            <span style="color:var(--color-danger);">Sin moto asignada</span>
        </div>
        <table class="moto-table">
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
                    @if($res->fecha_hasta->lt(now())) @continue @endif
                    @php $haySinMoto = true; @endphp
                    <tr>
                        <td><a href="{{ route('reservas.edit', $res) }}" class="edit-link">✏️</a></td>
                        <td style="font-weight:600;">{{ $res->cliente ?? '— sin cliente —' }}</td>
                        <td style="color:var(--color-muted);font-size:.85rem;">{{ $res->fecha_desde->format('d-m') }}</td>
                        <td style="color:var(--color-muted);font-size:.85rem;">{{ $res->fecha_hasta->format('d-m') }}</td>
                    </tr>
                @endforeach
                @unless($haySinMoto)
                    <tr><td colspan="4" class="empty-state">Sin reservas pendientes</td></tr>
                @endunless
            </tbody>
        </table>
    </div>

    {{-- Con moto asignada --}}
    <div class="card" style="padding:.75rem 1rem;">
        <div class="section-header">
            <span style="color:var(--color-success);">Con moto asignada</span>
            <button class="toggle-btn" onclick="toggleConMoto()">🔽</button>
        </div>
        <div id="conMotoBlock">
            <table class="moto-table">
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
                        @if($res->fecha_hasta->lt(now())) @continue @endif
                        @php $hayConMoto = true; @endphp
                        <tr>
                            <td><a href="{{ route('reservas.edit', $res) }}" class="edit-link">✏️</a></td>
                            <td>
                                <div style="font-weight:600;">{{ $res->cliente ?? '— sin cliente —' }}</div>
                                <div style="font-size:.8rem;color:var(--color-muted);">{{ $res->moto?->modelo ?? '' }}</div>
                            </td>
                            <td style="color:var(--color-muted);font-size:.85rem;">{{ $res->fecha_desde->format('d-m') }}</td>
                            <td style="color:var(--color-muted);font-size:.85rem;">{{ $res->fecha_hasta->format('d-m') }}</td>
                        </tr>
                    @endforeach
                    @unless($hayConMoto)
                        <tr><td colspan="4" class="empty-state">Sin reservas pendientes</td></tr>
                    @endunless
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function toggleConMoto() {
        const block = document.getElementById('conMotoBlock');
        block.style.display = block.style.display === 'none' ? '' : 'none';
    }
</script>
@endpush
