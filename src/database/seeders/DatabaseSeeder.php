<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar MotoSeeder solo en entornos distintos a producción
        if (!app()->environment('production')) {
            $this->call([
                MotoSeeder::class,
            ]);
        }
    }
}