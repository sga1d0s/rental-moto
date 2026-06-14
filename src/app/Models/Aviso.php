<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $fillable = ['texto', 'prioridad', 'completado'];

    protected $casts = ['completado' => 'boolean'];

    public function scopePendientes($query)
    {
        return $query->where('completado', false);
    }
}
