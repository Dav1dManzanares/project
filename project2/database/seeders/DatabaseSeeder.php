<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MembresiaSeeder;
use Database\Seeders\EntrenadorSeeder;
use Database\Seeders\SocioSeeder;
use Database\Seeders\ClaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "🚀 Iniciando seeding masivo...\n\n";
        
        echo "📋 Creando membresías...\n";
        $this->call(MembresiaSeeder::class);
        
        echo "👨‍🏫 Creando entrenadores...\n";
        $this->call(EntrenadorSeeder::class);
        
        echo "👥 Creando socios...\n";
        $this->call(SocioSeeder::class);
        
        echo "🏃‍♂️ Creando clases...\n";
        $this->call(ClaseSeeder::class);
        
        echo "💰 Creando pagos...\n";
        $this->call(PagoSeeder::class);
        
        echo "📝 Creando inscripciones...\n";
        $this->call(InscripcionSeeder::class);
        
        echo "⭐ Creando evaluaciones...\n";
        $this->call(EvaluacionSeeder::class);
        
        // echo "\n✅ ¡Seeding completado!\n";
        // echo "📊 Datos creados:\n";
        // echo "   - ~55 Membresías\n";
        // echo "   - ~105 Entrenadores\n";
        // echo "   - 2,000 Socios\n";
        // echo "   - 150 Clases\n";
        // echo "   - 5,000 Pagos\n";
        // echo "   - 3,000 Inscripciones\n";
        // echo "   - 2,500 Evaluaciones\n";
        // echo "   TOTAL: ~12,810 registros\n";
    }
    
}
