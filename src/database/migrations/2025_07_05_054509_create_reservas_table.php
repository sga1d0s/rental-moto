<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            // FK a motos
            $table->foreignId('moto_id')
                  ->nullable()
                  ->constrained('motos')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
            // Fechas de la reserva
            $table->date('fecha_recogida');
            $table->date('fecha_entrega');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}