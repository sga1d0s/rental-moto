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
    Schema::table('motos', function (Blueprint $table) {
        // Añade status_id
        $table->foreignId('status_id')
              ->nullable()
              ->after('comentarios')
              ->constrained('statuses')
              ->onUpdate('cascade')
              ->onDelete('set null');

        // Elimina el enum antiguo
        $table->dropColumn('estado');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('motos', function (Blueprint $table) {
        // Volver atrás: re-crear el enum
        $table->enum('estado', ['Libre','Reservada','Ocupada','Averiada','Otros'])
              ->default('Libre')
              ->after('fecha_itv');

        // Quitar la fk
        $table->dropConstrainedForeignId('status_id');
    });
}
};
