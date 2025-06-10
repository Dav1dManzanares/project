<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\Pago;
use App\Models\Clase;
use App\Models\Entrenador;
use App\Models\Inscripcion;
use App\Models\Evaluacion;
use App\Models\Membresia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Cache;

class BenchmarkController extends Controller
{
    public function benchmark(Request $request)
    {
        $iterations = $request->get('iterations', 2); // Múltiples iteraciones para promedio
        $limit = $request->get('limit', 50000);

        // Información del sistema
        $systemInfo = $this->getSystemInfo();

        // Limpiar cache de consultas
        // DB::connection()->getPdo()->exec('RESET QUERY CACHE');

        $results = [
            'system_info' => $systemInfo,
            'test_config' => [
                'iterations' => $iterations,
                'limit' => $limit,
                'timestamp' => now()->toDateTimeString()
            ],
            'benchmarks' => []
        ];

        // Ejecutar cada benchmark múltiples veces
        for ($i = 1; $i <= $iterations; $i++) {
            // echo "{Ejecutando iteración {$i}/{$iterations}...\n},";

            $iterationResults = $this->runSingleIteration($limit);
            $results['benchmarks'][] = $iterationResults;

            // Limpiar memoria entre iteraciones
            gc_collect_cycles();
        }

        // Calcular promedios y estadísticas
        $results['statistics'] = $this->calculateStatistics($results['benchmarks']);

        // Análisis de índices
        $results['index_analysis'] = $this->analyzeIndexes();

        // Recomendaciones
        // $results['recommendations'] = $this->generateRecommendations($results['statistics']);

        return response()->json($results, 200, [], JSON_PRETTY_PRINT);
    }

    private function runSingleIteration($limit)
    {
        $benchmarks = [];

        // 1. CONSULTAS BÁSICAS
        $benchmarks['basic_queries'] = $this->benchmarkBasicQueries($limit);

        // // 2. BÚSQUEDAS CON ÍNDICES
        $benchmarks['search_queries'] = $this->benchmarkSearchQueries($limit);

        // // 3. JOINS Y RELACIONES
        $benchmarks['join_queries'] = $this->benchmarkJoinQueries($limit);

        // // 4. AGREGACIONES
        $benchmarks['aggregation_queries'] = $this->benchmarkAggregationQueries($limit);

        // // 5. CONSULTAS COMPLEJAS
        $benchmarks['complex_queries'] = $this->benchmarkComplexQueries($limit);

        return $benchmarks;
    }

    private function benchmarkBasicQueries($limit)
    {
        $results = [];

        // Count 
        $results['socios_count'] = $this->measureQuery(function () use ($limit) {
            return Socio::limit($limit)->count(); // Optimizado
        });

        // Selects básicos
        $results['socios_select_all'] = $this->measureQuery(function () use ($limit) {
            return Socio::limit($limit)->get();
        });

        $results['socios_select_specific'] = $this->measureQuery(function () use ($limit) {
            return Socio::select('id', 'nombre', 'email')->limit($limit)->get();
        });

        return $results;
    }

    private function benchmarkSearchQueries($limit)
    {
        $results = [];

        // Búsqueda por email (debería usar índice)
        $results['search_by_email'] = $this->measureQuery(function () {
            return Socio::where('email', 'like', '%test%')->limit(100)->get();
        });

        // Búsqueda por nombre (debería usar índice)
        $results['search_by_name'] = $this->measureQuery(function () {
            return Socio::where('nombre', 'like', 'Juan%')->limit(100)->get();
        });

        // Búsqueda por membresía (foreign key con índice)
        $results['search_by_membresia'] = $this->measureQuery(function () {
            return Socio::where('membresia_id', 1)->limit(100)->get();
        });

        // Búsqueda por fecha (debería usar índice)
        $results['search_by_date'] = $this->measureQuery(function () {
            return Pago::where('fecha_pago', '>=', '2024-01-01')->limit(100)->get();
        });

        return $results;
    }

    private function benchmarkJoinQueries($limit)
    {
        $results = [];

        // Join con información relacionada
        $results['socios_with_membresia'] = $this->measureQuery(function () use ($limit) {
            return Socio::with('membresia')->limit($limit)->get();
        });

        // Join múltiple
        $results['socios_with_all_relations'] = $this->measureQuery(function () use ($limit) {
            return Socio::with(['membresia', 'pagos', 'inscripciones.clase'])
                ->limit($limit)->get();
        });

        // Inner join manual
        $results['socios_membresia_join'] = $this->measureQuery(function () use ($limit) {
            return DB::table('socios')
                ->join('membresias', 'socios.membresia_id', '=', 'membresias.id')
                ->select('socios.nombre', 'socios.email', 'membresias.nombre as membresia')
                ->limit($limit)->get();
        });

        return $results;
    }

    private function benchmarkAggregationQueries($limit)
    {
        $results = [];

        // Suma de pagos por socio
        $results['sum_pagos_by_socio'] = $this->measureQuery(function () {
            return Pago::selectRaw('socio_id, SUM(monto) as total, COUNT(*) as cantidad')
                ->groupBy('socio_id')
                ->orderBy('total', 'desc')
                ->limit(100)->get();
        });

        // Promedio por membresía
        $results['avg_pagos_by_membresia'] = $this->measureQuery(function () {
            return Pago::selectRaw('membresia_id, AVG(monto) as promedio, COUNT(*) as total_pagos')
                ->groupBy('membresia_id')
                ->get();
        });

        // Conteo de evaluaciones por clase
        $results['count_evaluaciones_by_clase'] = $this->measureQuery(function () {
            return Evaluacion::selectRaw('clase_id, COUNT(*) as total, AVG(puntaje) as promedio_puntaje')
                ->groupBy('clase_id')
                ->orderBy('promedio_puntaje', 'desc')
                ->get();
        });

        return $results;
    }

    private function benchmarkComplexQueries($limit)
    {
        $results = [];

        // Consulta compleja: Socios con más pagos
        $results['socios_top_pagadores'] = $this->measureQuery(function () {
            return DB::table('socios')
                ->join('pagos', 'socios.id', '=', 'pagos.socio_id')
                ->join('membresias', 'socios.membresia_id', '=', 'membresias.id')
                ->selectRaw('
                         socios.nombre, 
                         socios.apellido, 
                         membresias.nombre as membresia,
                         COUNT(pagos.id) as total_pagos,
                         SUM(pagos.monto) as total_monto
                     ')
                ->groupBy('socios.id', 'socios.nombre', 'socios.apellido', 'membresias.nombre')
                ->orderBy('total_monto', 'desc')
                ->limit(20)->get();
        });


        // Reporte mensual de ingresos
        $results['reporte_ingresos_mensual'] = $this->measureQuery(function () {
            return DB::table('pagos')
                ->join('membresias', 'pagos.membresia_id', '=', 'membresias.id')
                ->selectRaw('
                         YEAR(fecha_pago) as año,
                         MONTH(fecha_pago) as mes,
                         membresias.nombre as tipo_membresia,
                         COUNT(*) as total_pagos,
                         SUM(pagos.monto) as ingresos_totales
                     ')
                ->groupBy('año', 'mes', 'membresias.id', 'membresias.nombre')
                ->orderBy('año', 'desc')
                ->orderBy('mes', 'desc')
                ->limit(50)->get();
        });

        return $results;
    }

    // private function measureQuery($callback)
// VERSIÓN SIMPLIFICADA si la anterior es muy compleja
    private function measureQuery($callback)
    {
        // Limpiar memoria antes de medir
        gc_collect_cycles();

        $memBefore = memory_get_usage(false); // Memoria emulada (más sensible)
        $realMemBefore = memory_get_usage(true); // Memoria real
        $startTime = microtime(true);

        $result = $callback();

        $endTime = microtime(true);
        $memAfter = memory_get_usage(false);
        $realMemAfter = memory_get_usage(true);

        return [
            // Tiempo que tardó en ejecutarse la consulta
            'execution_time_ms' => round(($endTime - $startTime) * 1000, precision: 4),

            // Memoria que PHP contabiliza para esta consulta (útil para optimización)
            'php_memory_used_kb' => round(($memAfter - $memBefore) / 1024, precision: 2),

            // Memoria que el sistema operativo asignó al proceso (útil para monitoreo)
            'system_memory_allocated_kb' => round(($realMemAfter - $realMemBefore) / 1024, precision: 2),

            // Cantidad de registros/elementos devueltos por la consulta
            'records_returned' => is_countable($result) ? count($result) : 1,

            // Memoria total que está usando toda la aplicación
            'total_app_memory_usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
        ];
    }

    private function getLastQuery()
    {
        try {
            return DB::getQueryLog()[count(DB::getQueryLog()) - 1]['query'] ?? 'N/A';
        } catch (\Exception $e) {
            return 'Query log not available';
        }
    }

    private function getSystemInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'mysql_version' => DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown',
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'database_size_mb' => $this->getDatabaseSize(),
            'table_counts' => $this->getTableCounts(),
            'index_counts' => $this->getIndexCounts()
        ];
    }

    private function getDatabaseSize()
    {
        try {
            $size = DB::select("
                SELECT 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS db_size_mb
                FROM information_schema.tables 
                WHERE table_schema = DATABASE()
            ")[0]->db_size_mb ?? 0;
            return $size;
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    private function getTableCounts()
    {
        return [
            'membresias' => Membresia::count(),
            'entrenadores' => Entrenador::count(),
            'socios' => Socio::count(),
            'clases' => Clase::count(),
            'pagos' => Pago::count(),
            'inscripciones' => Inscripcion::count(),
            'evaluaciones' => Evaluacion::count()
        ];
    }

    private function getIndexCounts()
    {
        $tables = ['membresias', 'entrenadores', 'socios', 'clases', 'pagos', 'inscripciones', 'evaluaciones'];
        $indexCounts = [];

        foreach ($tables as $table) {
            try {
                $indexes = DB::select("SHOW INDEX FROM {$table}");
                $indexCounts[$table] = collect($indexes)->groupBy('Key_name')->count();
            } catch (\Exception $e) {
                $indexCounts[$table] = 0;
            }
        }

        return $indexCounts;
    }

    private function analyzeIndexes()
    {
        $analysis = [];
        $tables = ['membresias', 'entrenadores', 'socios', 'clases', 'pagos', 'inscripciones', 'evaluaciones'];

        foreach ($tables as $table) {
            try {
                $indexes = collect(DB::select("SHOW INDEX FROM {$table}"));
                $analysis[$table] = [
                    'total_indexes' => $indexes->groupBy('Key_name')->count(),
                    'unique_indexes' => $indexes->where('Non_unique', 0)->groupBy('Key_name')->count(),
                    'composite_indexes' => $indexes->groupBy('Key_name')->filter(function ($group) {
                        return $group->count() > 1;
                    })->count(),
                    'index_details' => $indexes->groupBy('Key_name')->map(function ($group) {
                        return [
                            'columns' => $group->pluck('Column_name')->toArray(),
                            'unique' => $group->first()->Non_unique == 0,
                            'cardinality' => $group->sum('Cardinality')
                        ];
                    })
                ];
            } catch (\Exception $e) {
                $analysis[$table] = ['error' => $e->getMessage()];
            }
        }

        return $analysis;
    }

    private function calculateStatistics($benchmarks)
    {
        $stats = [];

        // Obtener todas las métricas únicas
        $allMetrics = [];
        foreach ($benchmarks as $iteration) {
            $this->flattenArray($iteration, $allMetrics);
        }

        // Calcular estadísticas para cada métrica
        foreach ($allMetrics as $metric => $values) {
            if (is_numeric($values[0] ?? null)) {
                $stats[$metric] = [
                    'avg' => round(array_sum($values) / count($values), 4),
                    'min' => round(min($values), 4),
                    'max' => round(max($values), 4),
                    'median' => round($this->calculateMedian($values), 4),
                    'std_dev' => round($this->calculateStdDev($values), 4)
                ];
            }
        }

        return $stats;
    }

    private function flattenArray($array, &$result, $prefix = '')
    {
        foreach ($array as $key => $value) {
            $newKey = $prefix ? $prefix . '.' . $key : $key;

            if (is_array($value)) {
                $this->flattenArray($value, $result, $newKey);
            } else {
                if (!isset($result[$newKey])) {
                    $result[$newKey] = [];
                }
                $result[$newKey][] = $value;
            }
        }
    }

    private function calculateMedian($values)
    {
        sort($values);
        $count = count($values);
        $middle = floor($count / 2);

        if ($count % 2) {
            return $values[$middle];
        } else {
            return ($values[$middle - 1] + $values[$middle]) / 2;
        }
    }

    private function calculateStdDev($values)
    {
        $mean = array_sum($values) / count($values);
        $variance = array_sum(array_map(function ($value) use ($mean) {
            return pow($value - $mean, 2);
        }, $values)) / count($values);

        return sqrt($variance);
    }

    // private function generateRecommendations($statistics)
    // {
    //     $recommendations = [];

    //     // Analizar tiempos de ejecución
    //     foreach ($statistics as $metric => $stats) {
    //         if (strpos($metric, 'execution_time_ms') !== false) {
    //             if ($stats['avg'] > 1000) { // Más de 1 segundo
    //                 $recommendations[] = [
    //                     'type' => 'performance',
    //                     'severity' => 'high',
    //                     'metric' => $metric,
    //                     'message' => "La consulta '{$metric}' tiene un tiempo promedio de {$stats['avg']}ms. Considera optimizar con índices.",
    //                     'suggestion' => 'Revisar el plan de ejecución con EXPLAIN y agregar índices apropiados.'
    //                 ];
    //             } elseif ($stats['avg'] > 100) { // Más de 100ms
    //                 $recommendations[] = [
    //                     'type' => 'performance',
    //                     'severity' => 'medium',
    //                     'metric' => $metric,
    //                     'message' => "La consulta '{$metric}' podría optimizarse. Tiempo promedio: {$stats['avg']}ms.",
    //                     'suggestion' => 'Considera agregar índices o optimizar la consulta.'
    //                 ];
    //             }
    //         }
    //     }

    //     return $recommendations;
    // }
}