<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entrenador;

class EntrenadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entrenadores_base = [
            ['nombre' => 'Carlos', 'apellido' => 'Rodríguez', 'especialidad' => 'Musculación', 'horario' => 'Lunes a Viernes 6:00-14:00'],
            ['nombre' => 'María', 'apellido' => 'González', 'especialidad' => 'Yoga', 'horario' => 'Lunes, Miércoles, Viernes 16:00-20:00'],
            ['nombre' => 'José', 'apellido' => 'Martínez', 'especialidad' => 'CrossFit', 'horario' => 'Martes y Jueves 18:00-21:00'],
            ['nombre' => 'Ana', 'apellido' => 'López', 'especialidad' => 'Pilates', 'horario' => 'Sábados 9:00-13:00'],
            ['nombre' => 'Pedro', 'apellido' => 'Sánchez', 'especialidad' => 'Natación', 'horario' => 'Todos los días 8:00-12:00']
        ];

        foreach ($entrenadores_base as $entrenador) {
            Entrenador::create($entrenador);
        }

        // Crear masivamente
        Entrenador::factory(500)->create();
    }
    
}
