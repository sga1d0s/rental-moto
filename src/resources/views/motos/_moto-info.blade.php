<ul>
    <li><strong>Modelo:</strong> {{ $moto->modelo }}</li>
    <li><strong>Matrícula:</strong> {{ $moto->matricula }}</li>
    <li><strong>Kilómetros:</strong> {{ $moto->kilometros }}</li>
    <li><strong>Fecha ITV:</strong> {{ $moto->fecha_itv->format('d-m-Y') }}</li>
    <li><strong>Estado:</strong> {{ $moto->status->name }}</li>
</ul>