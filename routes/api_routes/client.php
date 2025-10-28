<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepresentanteController;

Route::get('clients', [RepresentanteController::class, 'index'])->name('client.index');
Route::get('client/show/{id}', [RepresentanteController::class, 'show'])->name('client.show');

Route::get('client/search/{request}', [RepresentanteController::class, 'search'])
    ->name('client.search');

Route::post('client/store', [RepresentanteController::class, 'store'])->name('client.store');

Route::post('client/update/{parent}', [RepresentanteController::class, 'update'])->name('client.update');
Route::post('client/updatestatusclient/{parent}', [RepresentanteController::class, 'updateStatusClient'])->name('client.updateStatusClient');
Route::post('client/updatestatusadmin/{parent}', [RepresentanteController::class, 'updateStatusAdmin'])->name('client.updateStatusAdmin');

Route::put('client/update/status/{parent:id}', [RepresentanteController::class, 'updateStatus'])
    ->name('client.updateStatus');
    
Route::delete('client/destroy/{id}', [RepresentanteController::class, 'destroy'])->name('client.destroy');
