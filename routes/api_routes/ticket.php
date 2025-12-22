<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('tickets', [TicketController::class, 'index'])->name('ticket.index');
Route::get('ticket/show/{id}', [TicketController::class, 'show'])->name('ticket.show');

Route::get('tickets/client/{from_id}', [TicketController::class, 'showbyClient'])->name('ticket.showbyClient');
Route::get('tickets/event/{event_id}/{client_id}', [TicketController::class, 'showbyEvent'])->name('ticket.showbyEvent');

Route::get('tickets/shared/{client_id}', [TicketController::class, 'shared'])->name('ticket.shared');
Route::get('tickets/tiketsactivos/{client_id}', [TicketController::class, 'tiketsactivos'])->name('ticket.tiketsactivos');
Route::get('tickets/tiketsactivosCompartidos/{client_id}', [TicketController::class, 'tiketsactivosCompartidos'])->name('ticket.tiketsactivosCompartidos');

Route::get('ticket/search/{request}', [TicketController::class, 'search'])
    ->name('ticket.search');
    
Route::post('ticket/store', [TicketController::class, 'storeTicket'])->name('ticket.storeTicket');

Route::post('ticket/compartir/{ticket_id}', [TicketController::class, 'compartir'])->name('ticket.compartir');
Route::post('ticket/verify/', [TicketController::class, 'verify'])->name('ticket.verify');

Route::post('ticket/update/{ticket_id}', [TicketController::class, 'update'])->name('ticket.update');

Route::delete('ticket/destroy/{id}', [TicketController::class, 'destroy'])->name('ticket.destroy');
