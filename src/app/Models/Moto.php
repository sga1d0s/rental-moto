<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    protected $fillable = [
        'modelo',
        'matricula',
        'kilometros',
        'fecha_itv',
        'comentarios',
        'status_id',
    ];

    protected $casts = [
        'fecha_itv' => 'date',
    ];

    // Relación al estado estático
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Relación a las reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    // Estado “computado” según la fecha y reservas
    public function getComputedStatusAttribute()
    {
        // 1) Averiada siempre prevalece
        if ($this->status && $this->status->name === 'Averiada') {
            return 'Averiada';
        }

        $hoy = now()->toDateString();

        // 2) Ocupada si hay reserva activa hoy
        if (
            $this->reservas()
                 ->where('fecha_desde', '<=', $hoy)
                 ->where('fecha_hasta', '>=', $hoy)
                 ->exists()
        ) {
            return 'Ocupada';
        }

        // 3) Reservada si hay reserva futura (recogida > hoy)
        if (
            $this->reservas()
                 ->where('fecha_desde', '>', $hoy)
                 ->exists()
        ) {
            return 'Reservada';
        }

        // 4) En el resto, Libre
        return 'Libre';
    }
}