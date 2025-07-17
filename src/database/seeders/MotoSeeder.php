<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moto;
use Faker\Factory as Faker;

class MotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lista de ejemplos de modelos de moto
        $modelos = [
            'Yamaha YZF-R1', 'Honda CB650R', 'Kawasaki Ninja 400',
            'BMW R1250GS', 'Ducati Monster 821', 'Suzuki SV650',
            'Triumph Street Triple', 'KTM 390 Duke', 'Harley-Davidson Iron 883',
            'Aprilia RSV4', 'MV Agusta Brutale 800', 'Royal Enfield Interceptor 650',
            'Honda CBR500R', 'Yamaha MT-07', 'Kawasaki Z650',
        ];

        for ($i = 0; $i < 15; $i++) {
            Moto::create([
                'modelo'      => $faker->randomElement($modelos),
                // Matrícula estilo español: 4 dígitos + 3 letras
                'matricula'   => strtoupper($faker->unique()->bothify('####???')),
                'kilometros'  => $faker->numberBetween(0, 80000),
                // ITV entre hace 2 años y dentro de 1 año
                'fecha_itv'   => $faker->dateTimeBetween('-2 years', '+1 year')->format('Y-m-d'),
                'comentarios' => $faker->optional(0.3)->sentence(6),
                // Asumiendo que tienes status_id del 1 al 4
                'status_id'   => $faker->numberBetween(1, 4),
            ]);
        }
    }
}