<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clase;

class ClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lotes = 15; // 15 lotes de 10 = 150
        $por_lote = 10;

        for ($i = 0; $i < $lotes; $i++) {
            Clase::factory($por_lote)->create();
            echo "Creadas " . (($i + 1) * $por_lote) . " clases...\n";
        }
    }
    
}
