<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Evaluacion; // Asegúrate de que la ruta sea correcta

class EvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lotes = 50; // 50 lotes de 100 = 5000
        $por_lote = 100;

        for ($i = 0; $i < $lotes; $i++) {
            Evaluacion::factory($por_lote)->create();
            echo "Creadas " . (($i + 1) * $por_lote) . " evaluaciones...\n";
        }
    }
    
}
