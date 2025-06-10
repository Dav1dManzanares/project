<?php

use App\Models\Clase;
use App\Models\Entrenador;
use App\Models\Pago;
use App\Models\Socio;
use App\Models\Evaluacion;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BenchmarkController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/benchmark', [BenchmarkController::class, 'benchmark']);
Route::get('/benchmark/simple', [BenchmarkController::class, 'benchmarkSimple']);

Route::get('/performance-test/{limit}', function ($limit) {

    // // clases
    // $startBenchmarkClases = microtime(true);
    // $clases = Clase::limit($limit)->get();
    // $timeBenchmarkClases = microtime(true) - $startBenchmarkClases;
    
    // //Entrenadores
    // $startBenchmarkEntrenadores = microtime(true);
    // $entrenadores = Entrenador::limit($limit)->get();
    // $timeBenchmarkEntrenadores = microtime(true) - $startBenchmarkEntrenadores;

    // //Evaluaciones
    // $startBenchmarkEvaluaciones = microtime(true);
    // $evaluaciones = Evaluacion::limit($limit)->get();
    // $timeBenchmarkEvaluaciones = microtime(true) - $startBenchmarkEvaluaciones;

    // //Inscripciones
    // $startBenchmarkInscripciones = microtime(true);
    // $inscripciones = Inscripcion::limit($limit)->get();
    // $timeBenchmarkInscripciones = microtime(true) - $startBenchmarkInscripciones;

    // // Membresias


    // // pagos
    // $startBenchmarkPagos = microtime(true);
    // $Pagos = Pago::limit($limit)->get() ->count();
    // $timeBenchmarkPagos = microtime(true) - $startBenchmarkPagos;

        // socios
    $startBenchmarkSocios = microtime(true);
    $socios = Socio::limit($limit)->get()->count();
    $timeBenchmarkSocios = microtime(true) - $startBenchmarkSocios;

    

    return [
        'time-Benchmark Socios' => $timeBenchmarkSocios,
        // 'time-Benchmark Clases' => $timeBenchmarkClases,
        // 'time-Benchmark Pagos' => $timeBenchmarkPagos,
        // 'time-Benchmark Entrenadores' => $timeBenchmarkEntrenadores,
        // 'time-Benchmark Evaluaciones' => $timeBenchmarkEvaluaciones,
        // 'time-Benchmark Inscripciones' => $timeBenchmarkInscripciones,
        // 'entrenadores' => $entrenadores->count(),
        // 'evaluaciones' => $evaluaciones->count(),
        // 'inscripciones' => $inscripciones->count(),
        'socios' => $socios,
        // 'clases' => $clases->count(),
        // 'pagos' => $Pagos
    ];
});