<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'moto_id',
        'cliente',
        'fecha_desde',
        'fecha_hasta',
        // añade aquí cliente, observaciones…
    ];

    protected $casts = [
        'fecha_desde' => 'date:Y-m-d',
        'fecha_hasta'  => 'date:Y-m-d',
    ];

    public function moto()
    {
        return $this->belongsTo(Moto::class);
    }
}
