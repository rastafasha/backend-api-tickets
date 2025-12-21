<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminPaymentController;


// Pagos
Route::get('payment', [AdminPaymentController::class, 'index'])
    ->name('payment.index');

Route::get('payment/show/{payment}', [AdminPaymentController::class, 'paymentShow'])
    ->name('payment.show');

Route::put('payment/update/{id}', [AdminPaymentController::class, 'paymentUpdate'])
    ->name('payment.update');

Route::delete('payment/destroy/{payment:id}', [AdminPaymentController::class, 'paymentDestroy'])
    ->name('payment.destroy');

Route::get('payment/recientes/', [AdminPaymentController::class, 'recientes'])
    ->name('payment.recientes');

Route::get('payment/pendientes', [AdminPaymentController::class, 'pagosPendientes'])
    ->name('payment.pagosPendientes');

Route::get('payment/search/', [AdminPaymentController::class, 'search'])
    ->name('payment.search');

Route::get('payment/pagosbyUser/{id}', [AdminPaymentController::class, 'pagosbyUser'])
    ->name('payment.pagosbyUser');

Route::get('payment/pendientesbyStudent/{id}', [AdminPaymentController::class, 'pagosPendientesbyStudent'])
    ->name('payment.pagosPendientesbyStudent');

Route::put('payment/update/status/{payment:id}', [AdminPaymentController::class, 'updateStatus'])
    ->name('payment.updateStatus');

Route::get('payment/paymentbyeventid/{event_id}', [AdminPaymentController::class, 'paymentbyevent'])
    ->name('payment.paymentbyevent');

Route::get('payment/paymentbyeventbyclient/{event_id}/{client_id}', [AdminPaymentController::class, 'paymentbyeventbyclient'])
    ->name('payment.paymentbyeventbyclient');

// Check debt status routes
Route::get('payment/check-debt-status/{parent_id}/{student_id}', [AdminPaymentController::class, 'checkDebtStatus'])
    ->name('payment.checkDebtStatus');

Route::get('payment/check-debt-status-p/{parent_id}', [AdminPaymentController::class, 'checkDebtStatusByParent'])
    ->name('payment.checkDebtStatusByParent');

Route::get('payment/debt-by-parent/{parent_id}', [AdminPaymentController::class, 'viewDebtByParent'])
    ->name('payment.viewDebtByParent');

Route::post('payment/pay-debt/{client_id}/{event_id}', [AdminPaymentController::class, 'payDebtForEvent'])
    ->name('payment.payDebtForEvent');



