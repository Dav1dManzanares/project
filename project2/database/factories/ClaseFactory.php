<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Clase;
use App\Models\Entrenador;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clase>
 */
class ClaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos_clases = [
            ['nombre' => 'Pesas Principiantes', 'descripcion' => 'Introducción al entrenamiento con pesas básico'],
            ['nombre' => 'Pesas Avanzado', 'descripcion' => 'Entrenamiento intensivo con pesas para nivel avanzado'],
            ['nombre' => 'Yoga Relajación', 'descripcion' => 'Sesiones de yoga para relajación y flexibilidad'],
            ['nombre' => 'Yoga Power', 'descripcion' => 'Yoga dinámico para fortalecimiento'],
            ['nombre' => 'CrossFit Beginner', 'descripcion' => 'CrossFit adaptado para principiantes'],
            ['nombre' => 'CrossFit RX', 'descripcion' => 'CrossFit de alta intensidad nivel competitivo'],
            ['nombre' => 'Pilates Mat', 'descripcion' => 'Pilates en colchoneta para fortalecimiento del core'],
            ['nombre' => 'Pilates Reformer', 'descripcion' => 'Pilates con equipos especializados'],
            ['nombre' => 'Natación Libre', 'descripcion' => 'Práctica libre de natación con supervisión'],
            ['nombre' => 'Natación Técnica', 'descripcion' => 'Perfeccionamiento de técnicas de natación'],
            ['nombre' => 'Spinning', 'descripcion' => 'Ciclismo indoor con música motivadora'],
            ['nombre' => 'Aeróbicos', 'descripcion' => 'Ejercicios cardiovasculares con coreografía'],
            ['nombre' => 'Zumba', 'descripcion' => 'Baile fitness con ritmos latinos'],
            ['nombre' => 'Boxeo', 'descripcion' => 'Entrenamiento de boxeo para fitness'],
            ['nombre' => 'Funcional', 'descripcion' => 'Entrenamiento funcional con movimientos naturales'],
            ['nombre' => 'TRX', 'descripcion' => 'Entrenamiento en suspensión']
        ];

        $horarios = [
            'Lunes y Miércoles 6:00-7:00',
            'Martes y Jueves 7:00-8:00',
            'Lunes, Miércoles, Viernes 18:00-19:00',
            'Martes y Jueves 19:00-20:00',
            'Sábados 9:00-10:00',
            'Domingos 10:00-11:00',
            'Lunes a Viernes 12:00-13:00',
            'Fines de semana 16:00-17:00'
        ];

        $clase = fake()->randomElement($tipos_clases);

        return [
            'nombre' => $clase['nombre'] . ' ' . fake()->randomNumber(2),
            'descripcion' => $clase['descripcion'] . '. ' . fake()->sentence(),
            'horario' => fake()->randomElement($horarios),
            'capacidad' => fake()->numberBetween(8, 30),
            'entrenador_id' => Entrenador::factory()
        ];
    }
}
