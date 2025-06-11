<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Membresia; // Asegúrate de que la ruta sea correcta
// Asegúrate de que la ruta sea correcta
    

class MembresiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $membresias_basicas = [
            ['nombre' => 'Básica Estándar', 'duracion' => 30, 'monto' => 25.00],
            ['nombre' => 'Premium Estándar', 'duracion' => 30, 'monto' => 45.00],
            ['nombre' => 'VIP Estándar', 'duracion' => 30, 'monto' => 65.00],
            ['nombre' => 'Estudiantil Estándar', 'duracion' => 30, 'monto' => 20.00],
            ['nombre' => 'Anual Básica Estándar', 'duracion' => 365, 'monto' => 250.00]
        ];

        foreach ($membresias_basicas as $membresia) {
            Membresia::create($membresia);
        }

        // Luego crear masivamente
        Membresia::factory(200)->create();
    }

}
