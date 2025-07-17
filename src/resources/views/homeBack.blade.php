@extends('layout')

@section('title', 'Listado de Motos')

@section('content')
  <h1>Listado de Motos</h1>
  <p><a href="{{ route('motos.create') }}">➕ Añadir Moto Nueva</a></p>

  @if($motos->isEmpty())
    <p>No hay motos registradas.</p>
  @else
    <table>
      {{-- <thead>
        <tr>
          <th>ID</th><th>Modelo</th><th>Matrícula</th>
          <th>Km</th><th>Fecha ITV</th><th>Estado</th>
          <th>Comentarios</th><th>Acciones</th>
        </tr>
      </thead> --}}
      <tbody>
        @foreach($motos as $moto)
          <tr>
            <td data-label="ID">{{ $moto->id }}</td>
            <td data-label="Modelo">{{ $moto->modelo }}</td>
            <td data-label="Matrícula">{{ $moto->matricula }}</td>
            <td data-label="Km">{{ $moto->kilometros }}</td>
            <td data-label="Fecha ITV">{{ $moto->fecha_itv->format('d-m-Y') }}</td>
            <td data-label="Estado">{{ $moto->estado }}</td>
            <td data-label="Comentarios">{{ $moto->comentarios }}</td>
            <td data-label="Acciones">
              <a href="{{ route('motos.edit', $moto) }}">✏️</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection