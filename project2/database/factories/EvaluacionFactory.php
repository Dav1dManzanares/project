<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Evaluacion;
use App\Models\Socio;
use App\Models\Clase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluacion>
 */
class EvaluacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comentarios_positivos = [
            'Excelente clase, muy motivadora',
            'El entrenador explica muy bien',
            'Instalaciones muy limpias',
            'Ambiente muy agradable',
            'Rutina muy efectiva',
            'Me encanta esta clase',
            'Horario perfecto para mí',
            'Veo resultados rápidamente'
        ];

        $comentarios_neutros = [
            'Buena clase en general',
            'Está bien, puede mejorar',
            'Cumple con las expectativas',
            'Clase estándar',
            'No está mal'
        ];

        $comentarios_negativos = [
            'Podría ser mejor',
            'Falta más variedad',
            'El horario no me convence',
            'Esperaba más'
        ];

        $puntaje = fake()->numberBetween(1, 5);
        
        if ($puntaje >= 4) {
            $comentario = fake()->randomElement($comentarios_positivos);
        } elseif ($puntaje == 3) {
            $comentario = fake()->randomElement($comentarios_neutros);
        } else {
            $comentario = fake()->randomElement($comentarios_negativos);
        }

        return [
            'puntaje' => $puntaje,
            'comentario' => $comentario . '. ' . fake()->sentence(),
            'socio_id' => Socio::inRandomOrder()->first()?->id ?? Socio::factory(),
            'clase_id' => Clase::inRandomOrder()->first()?->id ?? Clase::factory()
        ];
    }
}
