<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membresia;
use App\Models\Socio;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'monto' => fake()->randomFloat(2, 15, 150),
            'fecha_pago' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'membresia_id' => Membresia::inRandomOrder()->first()?->id ?? Membresia::factory(),
            'socio_id' => Socio::inRandomOrder()->first()?->id ?? Socio::factory()
        ];
    }
}
