<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Inscripcion;
use App\Models\Socio;
use App\Models\Clase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inscripcion>
 */
class InscripcionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha_inscripcion' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'socio_id' => Socio::inRandomOrder()->first()?->id ?? Socio::factory(),
            'clase_id' => Clase::inRandomOrder()->first()?->id ?? Clase::factory()
        ];
    }
}
