<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasaBcvController;

// 1. Rutas Estáticas (SIEMPRE PRIMERO)
Route::get('tasabcvs', [TasaBcvController::class, 'index'])->name('tasabcv.index');
Route::get('tasabcv/ultimatasa', [TasaBcvController::class, 'ultimatasa'])->name('tasabcv.ultimatasa');

// 2. Rutas Dinámicas con Parámetros (DESPUÉS)
Route::get('tasabcv/show/{id}', [TasaBcvController::class, 'show'])->name('tasabcv.show');
Route::get('tasabcv/search/{request}', [TasaBcvController::class, 'search'])->name('tasabcv.search');

// 3. Rutas de escritura (POST, DELETE)
Route::post('tasabcv/store', [TasaBcvController::class, 'store'])->name('tasabcv.store');
Route::post('tasabcv/update/{proveedor}', [TasaBcvController::class, 'update'])->name('tasabcv.update');
Route::delete('tasabcv/destroy/{id}', [TasaBcvController::class, 'destroy'])->name('tasabcv.destroy');
