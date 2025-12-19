<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('companies', [CompanyController::class, 'index'])->name('company.index');
Route::get('company/show/{id}', [CompanyController::class, 'show'])->name('company.show');

Route::get('company/eventsby/{company_id}', [CompanyController::class, 'eventsbyCompany'])->name('company.eventsbyCompany');
Route::get('company/usersby/{company_id}', [CompanyController::class, 'usersbyCompany'])->name('company.usersbyCompany');

Route::get('company/search/{request}', [CompanyController::class, 'search'])
    ->name('company.search');
    
Route::post('company/store', [CompanyController::class, 'companystore'])->name('company.companystore');

Route::post('company/addcolaborador/{company_id}', [CompanyController::class, 'addEmployee'])->name('company.addEmployee');
Route::post('company/removecolaborador/{company_id}', [CompanyController::class, 'removeEmployee'])->name('company.removeEmployee');

Route::post('company/addEvent/{company_id}', [CompanyController::class, 'addEvent'])->name('company.addEvent');
Route::post('company/removeEvent/{company_id}', [CompanyController::class, 'removeEvent'])->name('company.removeEvent');


Route::post('company/update/{company}', [CompanyController::class, 'update'])->name('company.update');
// Route::post('company/updatecom/{company}', [CompanyController::class, 'companyUpdate'])->name('company.companyUpdate');

Route::delete('company/destroy/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
