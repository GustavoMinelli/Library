<?php

use App\Http\Controllers\BookRentController;
use Illuminate\Support\Facades\Route;

Route::prefix('aluguel-de-livros')->group(function() {

    Route::get('/', [BookRentController::class, 'index'])->name('book-rents.index');
    Route::get('/criar', [BookRentController::class, 'create'])->name('book-rents.create');
    Route::get('/{bookRent}/editar/', [BookRentController::class, 'edit'])->name('book-rents.edit');
    Route::delete('/{bookRent}', [BookRentController::class, 'destroy'])->name('book-rents.delete');
    Route::post('/', [BookRentController::class, 'insert'])->name('book-rents.insert');
    Route::put('/', [BookRentController::class, 'update'])->name('book-rents.update');


});