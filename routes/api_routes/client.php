<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::get('clients', [ClienteController::class, 'index'])->name('client.index');
Route::get('client/show/{id}', [ClienteController::class, 'show'])->name('client.show');

Route::get('client/search/{request}', [ClienteController::class, 'search'])
    ->name('client.search');

Route::post('client/store', [ClienteController::class, 'store'])->name('client.store');

Route::post('client/update/{parent}', [ClienteController::class, 'update'])->name('client.update');
Route::post('client/updatestatusclient/{parent}', [ClienteController::class, 'updateStatusClient'])->name('client.updateStatusClient');
Route::post('client/updatestatusadmin/{parent}', [ClienteController::class, 'updateStatusAdmin'])->name('client.updateStatusAdmin');
Route::post('client/invitarCliente', [ClienteController::class, 'invitarCliente'])->name('client.invitarCliente');

Route::put('client/update/status/{parent:id}', [ClienteController::class, 'updateStatus'])
    ->name('client.updateStatus');
    
Route::delete('client/destroy/{id}', [ClienteController::class, 'destroy'])->name('client.destroy');
