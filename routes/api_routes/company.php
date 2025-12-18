<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('companies', [CompanyController::class, 'index'])->name('company.index');
Route::get('company/show/{id}', [CompanyController::class, 'show'])->name('company.show');

Route::get('company/search/{request}', [CompanyController::class, 'search'])
    ->name('company.search');
    
Route::post('company/store', [CompanyController::class, 'companystore'])->name('company.companystore');

Route::post('company/update/{company}', [CompanyController::class, 'update'])->name('company.update');

Route::delete('company/destroy/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
