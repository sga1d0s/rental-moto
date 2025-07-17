<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Libre, Alquilada, Averiada, Otros…
            $table->timestamps();
        });

        // Seed inicial (opcional, puedes usar un seeder en su lugar)
        DB::table('statuses')->insert([
            ['name' => 'Libre'],
            ['name' => 'Reservada'],
            ['name' => 'Ocupada'],
            ['name' => 'Averiada'],
            ['name' => 'Otros'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
