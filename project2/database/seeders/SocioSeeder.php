<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Socio;

class SocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lotes = 40; // 40 lotes de 50 = 2000
        $por_lote = 50;

        for ($i = 0; $i < $lotes; $i++) {
            Socio::factory($por_lote)->create();
            
            // Mostrar progreso
            $total_creados = ($i + 1) * $por_lote;
            echo "Creados {$total_creados} socios...\n";
        }
    }
    
}
