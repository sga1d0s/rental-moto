@extends('layout')

@section('title', 'Listado de Motos')

@section('content')

    <div class="page-header">
        <h1>Motos</h1>
        <a href="{{ route('motos.create') }}" class="btn-add">＋ Añadir</a>
    </div>

    <div class="card" style="padding:.5rem 1rem;">
        <table class="moto-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Modelo</th>
                    <th></th>
                    <th>Desde</th>
                    <th>Hasta</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($motos as $moto)
                    @php
                        $statusColors = [
                            'Libre'     => '#22c55e',
                            'Ocupada'   => '#ef4444',
                            'Reservada' => '#f59e0b',
                            'Averiada'  => '#111',
                            'Otros'     => '#a1a1aa',
                        ];
                        $color = $statusColors[$moto->computed_status] ?? '#a1a1aa';
                        $reservaDesde = $moto->reservas->where('fecha_desde', '>=', now()->toDateString())->sortBy('fecha_desde')->first();
                        $reservaHasta = $moto->reservas->where('fecha_hasta', '>=', now()->toDateString())->sortBy('fecha_hasta')->first();
                    @endphp
                    <tr>
                        <td><a href="{{ route('motos.edit', $moto) }}" class="edit-link">✏️</a></td>
                        <td>
                            <a href="#" class="moto-link" style="color:var(--color-text);font-weight:600;"
                                data-id="{{ $moto->id }}"
                                data-url="{{ route('motos.partial', $moto) }}"
                                data-bs-toggle="modal"
                                data-bs-target="#motoModal">
                                {{ $moto->modelo }}
                            </a>
                        </td>
                        <td>
                            <span class="status-dot" style="background:{{ $color }};"></span>
                        </td>
                        <td style="color:var(--color-muted);font-size:.85rem;">
                            {{ $reservaDesde ? \Carbon\Carbon::parse($reservaDesde->fecha_desde)->format('d-m') : '—' }}
                        </td>
                        <td style="color:var(--color-muted);font-size:.85rem;">
                            {{ $reservaHasta ? \Carbon\Carbon::parse($reservaHasta->fecha_hasta)->format('d-m') : '—' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal detalles moto -->
    <div class="modal fade" id="motoModal" tabindex="-1" aria-labelledby="motoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:var(--radius);border:none;box-shadow:var(--shadow);">
                <div class="modal-header" style="border-bottom:1px solid var(--color-border);">
                    <h5 class="modal-title" id="motoModalLabel" style="font-weight:700;">Detalles de la moto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="moto-info" style="padding:1.25rem;">
                    Cargando…
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.moto-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const el = e.currentTarget;
                    const url = el.dataset.url || `/motos/${el.dataset.id}/partial`;
                    const container = document.getElementById('moto-info');
                    container.textContent = 'Cargando…';
                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => { if (!res.ok) throw new Error(res.status); return res.text(); })
                        .then(html => { container.innerHTML = html; })
                        .catch(() => { container.textContent = 'No se pudo cargar la información.'; });
                });
            });
        });
    </script>

@endsection
