@extends('layout')

@section('title', 'Listado de Motos')

@section('content')
    <h1 class="mb-4">Listado de MotoS</h1>
    <p><a href="{{ route('motos.create') }}">➕ Añadir Moto</a></p>

    <table class="table-auto w-full border-collapse">

        <tbody>
            <tr>
                <th>
                    <th>Moto</th>
                    <th></th>
                    <th>Hasta</th>
                </th>
            </tr>
            @foreach ($motos as $moto)
                <tr class="border-t">
                    {{-- 0) Editar moto --}}
                    <td>
                        <a href="{{ route('motos.edit', $moto) }}">✏️</a>
                    </td>

                    {{-- 1) Nombre de la moto --}}
                    <td class="px-4 py-2">{{ $moto->modelo }}</td>

                    {{-- 2) Estado computado con indicador de color --}}
                    <td class="px-4 py-2">
                        @php
                            $statusColors = [
                                'Libre'     => '#28a745', // verde
                                'Ocupada'   => '#dc3545', // rojo
                                'Reservada' => '#ffc107', // amarillo
                                'Averiada'  => '#000000', // negro
                                'Otros'     => '#6c757d', // gris
                            ];
                            $color = $statusColors[$moto->computed_status] ?? '#6c757d';
                        @endphp
                        <span style="display:inline-block; width:12px; height:12px; border-radius:50%; background-color:{{ $color }};"></span>
                    </td>

                    {{-- 3) Fecha de entrega (si existe alguna reserva) --}}
                    <td class="px-4 py-2">
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
@endsection