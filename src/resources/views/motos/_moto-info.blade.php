<ul class="moto-info-list">
    <li>
        <strong>Modelo</strong>
        <span>{{ $moto->modelo }}</span>
    </li>
    <li>
        <strong>Matrícula</strong>
        <span>{{ $moto->matricula }}</span>
    </li>
    <li>
        <strong>Kilómetros</strong>
        <span>{{ number_format($moto->kilometros, 0, ',', '.') }} km</span>
    </li>
    <li>
        <strong>ITV</strong>
        <span>{{ $moto->fecha_itv->format('d-m-Y') }}</span>
    </li>
    <li>
        <strong>Estado</strong>
        <span>{{ $moto->status->name }}</span>
    </li>
</ul>
