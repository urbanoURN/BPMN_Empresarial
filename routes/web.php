<?php

use App\Http\Controllers\ProcessController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('processes.index'));

Route::resource('processes', ProcessController::class);

// Ruta extra para exportar el .bpmn
Route::get('processes/{process}/export', [ProcessController::class, 'export'])
    ->name('processes.export');