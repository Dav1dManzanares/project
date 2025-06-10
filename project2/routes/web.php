<?php

use App\Models\Socio;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/performance-test/', function () {
    // 1. Consulta SIN índice
    $startTestIndex = microtime(true);
    Socio::all()->count();
    $timeTestIndex = microtime(true) - $startTestIndex;

    return [
        'time-Test Index' => $timeTestIndex,
    ];
});