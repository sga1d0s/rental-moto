@extends('layout')

@section('title', 'Listado de Motos')

@section('content')
    <h1 class="mb-4 fw-bold ">Listado de Motos</h1>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <a href="{{ route('motos.create') }}">➕ Añadir Moto</a>
        <strong style="color: red;">
            {{ now()->format('d-m-Y') }}
        </strong>
    </div>

    <table class="table-auto w-full border-collapse">
        <tbody>
            <tr>
                <th></th>
                <th>Moto</th>
                <th></th>
                <th>Desde</th>
                <th>Hasta</th>
            </tr>
            @foreach ($motos as $moto)
                <tr class="border-t">
                    {{-- 0) Editar moto --}}
                    <td>
                        <a href="{{ route('motos.edit', $moto) }}">✏️</a>
                    </td>

                    {{-- 1) Nombre de la moto, mostrar info --}}
                    <td class="px-6 py-2">
                        <a href="#" class="moto-link" data-id="{{ $moto->id }}"
                            data-url="{{ route('motos.partial', $moto) }}" data-bs-toggle="modal"
                            data-bs-target="#motoModal">
                            {{ $moto->modelo }}
                        </a>
                    </td>

                    {{-- 2) Estado computado con indicador de color --}}
                    <td class="">
                        @php
                            $statusColors = [
                                'Libre' => '#28a745', // verde
                                'Ocupada' => '#dc3545', // rojo
                                'Reservada' => '#ffc107', // amarillo
                                'Averiada' => '#000000', // negro
                                'Otros' => '#6c757d', // gris
                            ];
                            $color = $statusColors[$moto->computed_status] ?? '#6c757d';
                        @endphp
                        <span
                            style="display:inline-block; width:12px; height:12px; border-radius:50%; background-color:{{ $color }};"></span>
                    </td>

                    {{-- 3) Fecha de desde (si existe alguna reserva) --}}
                    <td class="">
                        @php
                            $reserva = $moto->reservas
                                ->where('fecha_desde', '>=', now()->toDateString())
                                ->sortBy('fecha_desde')
                                ->first();
                        @endphp

                        @if ($reserva)
                            {{ \Carbon\Carbon::parse($reserva->fecha_desde)->format('d-m') }}
                        @else
                            &mdash;
                        @endif
                    </td>

                    {{-- 4) Fecha de hasta (si existe alguna reserva) --}}
                    <td class="">
                        @php
                            $reserva = $moto->reservas
                                ->where('fecha_hasta', '>=', now()->toDateString())
                                ->sortBy('fecha_hasta')
                                ->first();
                        @endphp

                        @if ($reserva)
                            {{ \Carbon\Carbon::parse($reserva->fecha_hasta)->format('d-m') }}
                        @else
                            &mdash;
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal para mostrar detalles de la moto -->
    <div class="modal fade" id="motoModal" tabindex="-1" aria-labelledby="motoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="motoModalLabel">Detalles de la Moto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="moto-info">
                    Cargando...
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.moto-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();

                    const el = e.currentTarget; // always the <a>, not a child text node
                    const url = el.dataset.url || `/motos/${el.dataset.id}/partial`;
                    const infoContainer = document.getElementById('moto-info');

                    // Estado inicial del modal
                    infoContainer.textContent = 'Cargando...';

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then((res) => {
                            if (!res.ok) {
                                throw new Error(`Error HTTP ${res.status}`);
                            }
                            return res.text();
                        })
                        .then((html) => {
                            infoContainer.innerHTML = html;
                        })
                        .catch((err) => {
                            console.error(err);
                            infoContainer.textContent =
                                'No se pudo cargar la información de la moto.';
                        });
                });
            });
        });
    </script>

@endsection
