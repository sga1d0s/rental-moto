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
    Schema::create('high_scores', function (Blueprint $table) {
      $table->id();
      $table->string('game', 50)->default('forge_in_the_hell'); // por si luego tienes más juegos
      $table->string('name', 3);
      $table->unsignedInteger('score');
      $table->timestamps();

      $table->index(['game', 'score']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('high_scores');
  }
};
