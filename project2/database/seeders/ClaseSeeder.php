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
        $lotes = 50; // 500 lotes de 100 = 50000
        $por_lote = 100;

        for ($i = 0; $i < $lotes; $i++) {
            Clase::factory($por_lote)->create();
            echo "Creadas " . (($i + 1) * $por_lote) . " clases...\n";
        }
    }
    
}
