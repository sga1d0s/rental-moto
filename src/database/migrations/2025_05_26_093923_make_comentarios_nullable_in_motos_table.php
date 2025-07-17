<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('motos', function (Blueprint $table) {
            // Cambiamos la columna a nullable
            $table->string('comentarios')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('motos', function (Blueprint $table) {
            // Volvemos a no permitir null
            $table->string('comentarios')->nullable(false)->change();
        });
    }
};