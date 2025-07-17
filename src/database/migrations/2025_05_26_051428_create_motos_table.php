<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotosTable extends Migration
{
    public function up()
    {
        Schema::create('motos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('matricula');
            $table->integer('kilometros');
            $table->date('fecha_itv');
            $table->enum('estado', ['Libre', 'Alquilada', 'Averiada', 'Otros'])->default('Libre');
            $table->string('comentarios');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('motos');
    }
}
