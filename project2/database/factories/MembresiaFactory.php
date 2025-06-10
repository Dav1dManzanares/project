<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membresia>
 */
class MembresiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos = [
            ['nombre' => 'Básica', 'duracion' => 30, 'monto' => fake()->randomFloat(2, 20, 30)],
            ['nombre' => 'Premium', 'duracion' => 30, 'monto' => fake()->randomFloat(2, 40, 55)],
            ['nombre' => 'VIP', 'duracion' => 30, 'monto' => fake()->randomFloat(2, 60, 80)],
            ['nombre' => 'Estudiantil', 'duracion' => 30, 'monto' => fake()->randomFloat(2, 15, 25)],
            ['nombre' => 'Anual Básica', 'duracion' => 365, 'monto' => fake()->randomFloat(2, 200, 300)],
            ['nombre' => 'Anual Premium', 'duracion' => 365, 'monto' => fake()->randomFloat(2, 400, 600)],
            ['nombre' => 'Familiar', 'duracion' => 30, 'monto' => fake()->randomFloat(2, 80, 120)],
            ['nombre' => 'Senior', 'duracion' => 30, 'monto' => fake()->randomFloat(2, 25, 35)],
        ];

        $tipo = fake()->randomElement($tipos);

        return [
            'nombre' => $tipo['nombre'] . ' ' . fake()->randomNumber(2),
            'duracion' => $tipo['duracion'],
            'monto' => $tipo['monto']
        ];
    }
}
