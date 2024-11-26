<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('clientes')->group(function() {

    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/criar', [CustomerController::class, 'create'])->name('customers.create');
    Route::get('/{customer}/editar/', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customers.delete');
    Route::post('/', [CustomerController::class, 'insert'])->name('customers.insert');
    Route::put('/', [CustomerController::class, 'update'])->name('customers.update');

});