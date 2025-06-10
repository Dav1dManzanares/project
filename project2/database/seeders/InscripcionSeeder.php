<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inscripcion; // Asegúrate de que la ruta sea correcta

class InscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lotes = 100; // 100 lotes de 100 = 10000
        $por_lote = 100;

        for ($i = 0; $i < $lotes; $i++) {
            Inscripcion::factory($por_lote)->create();
            echo "Creadas " . (($i + 1) * $por_lote) . " inscripciones...\n";
        }
    }
    
}
