<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {
            // renombra las columnas
            $table->renameColumn('fecha_recogida', 'fecha_desde');
            $table->renameColumn('fecha_entrega',  'fecha_hasta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            // regresa al nombre original
            $table->renameColumn('fecha_desde',  'fecha_recogida');
            $table->renameColumn('fecha_hasta',  'fecha_entrega');
        });
    }
};
