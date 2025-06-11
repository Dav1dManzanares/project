<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pago; // Asegúrate de que la ruta sea correcta

class PagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lotes = 50; // 100 lotes de 100 = 10000
        $por_lote = 100;

        for ($i = 0; $i < $lotes; $i++) {
            Pago::factory($por_lote)->create();
            echo "Creados " . (($i + 1) * $por_lote) . " pagos...\n";
        }
    }
   
}
