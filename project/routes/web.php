<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/performance-test/:num', function () {
    // 1. Consulta SIN índice
    $startTestIndex = microtime(true);
    Product::where('is_active', true)->count();
    $timeTestIndex = microtime(true) - $startTestIndex;

    return [
        'time-Test Index' => $timeTestIndex,
    ];
});

Route::get('/remove-index', function () {

    try {
        // 2. Eliminar índice 
        DB::statement('ALTER TABLE products DROP INDEX products_is_active_index');
        return [
            'message' => 'indice eliminado correctamente.',
        ];
    } catch (\Exception $e) {
        return [
            'error' => 'No se pudo eliminar el indice. no existe el indice products_is_active_index.',
        ];
    }

});



// Agrega el índice a la columna is_active de la tabla products
Route::get('/add-index', function () {
    try {
        DB::statement('ALTER TABLE products ADD INDEX products_is_active_index(is_active)');

        return [
            'message' => 'indice agregado correctamente.',
        ];
    } catch (\Exception $e) {
        return [
            'error' => 'No se pudo agregar el indice, ya existe el indice products_is_active_index.',
        ];
    }
});
