<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrenador>
 */
class EntrenadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $especialidades = [
            'Musculación', 'Yoga', 'CrossFit', 'Pilates', 'Natación',
            'Spinning', 'Aeróbicos', 'Zumba', 'Boxeo', 'Karate',
            'Taekwondo', 'Funcional', 'Calistenia', 'Powerlifting',
            'Stretching', 'Aqua Aeróbicos', 'TRX', 'Kettlebell'
        ];

        $horarios = [
            'Lunes a Viernes 6:00-14:00',
            'Lunes a Viernes 14:00-22:00',
            'Fines de Semana 8:00-16:00',
            'Martes y Jueves 18:00-21:00',
            'Lunes, Miércoles, Viernes 16:00-20:00',
            'Sábados y Domingos 9:00-13:00',
            'Todos los días 8:00-12:00',
            'Lunes a Sábado 10:00-18:00'
        ];

        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'especialidad' => fake()->randomElement($especialidades),
            'horario' => fake()->randomElement($horarios)
        ];
    }
}
