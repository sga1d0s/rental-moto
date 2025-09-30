<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            // cliente como string (varchar), nullable
            $table->string('cliente', 120)
                ->nullable()
                ->after('moto_id');

            // comentarios como text, nullable
            $table->text('comentarios')
                ->nullable()
                ->after('fecha_hasta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn(['cliente', 'comentarios']);
        });
    }
};
