<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product; // Asegúrate de importar el modelo Product

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunkSize = 1000;
        $totalRecords = 1000000;

        for ($i = 0; $i < ($totalRecords / $chunkSize); $i++) {
            $data = [];
            for ($j = 0; $j < $chunkSize; $j++) {
                $data[] = [
                    'name' => 'Product ' . ($i * $chunkSize + $j),
                    'is_active' => rand(0, 1), // Valores aleatorios 0/1
                ];
            }
            Product::insert($data);
        }
    }
}
