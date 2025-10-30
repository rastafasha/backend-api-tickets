<?php

use App\Http\Controllers\EventoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('events', [EventoController::class, 'index'])->name('event.index');
Route::get('events/activos/', [EventoController::class, 'activos'])->name('event.activos');
Route::get('event/show/{id}', [EventoController::class, 'show'])->name('event.show');
Route::get('event/clientsbyEvent/{id}', [EventoController::class, 'clientsbyEvent'])->name('event.clientsbyEvent');
Route::get('event/eventsbyuser/{id}', [EventoController::class, 'eventsbyUser'])->name('event.eventsbyUser');
Route::get('event/paymentbyid/{id}', [EventoController::class, 'paymentbyevent'])->name('event.paymentbyevent');

Route::get('event/search/{request}', [EventoController::class, 'search'])
    ->name('event.search');
    
Route::post('event/store', [EventoController::class, 'eventstore'])->name('event.eventstore');

Route::post('event/update/{student}', [EventoController::class, 'update'])->name('event.update');
Route::post('event/updatestatus/admin/{student}', [EventoController::class, 'updateStatusAdmin'])->name('event.updateStatusAdmin');

Route::put('event/update/status/{student:id}', [EventoController::class, 'updateStatus'])
    ->name('event.updateStatus');

Route::delete('event/destroy/{id}', [EventoController::class, 'destroy'])->name('event.destroy');
