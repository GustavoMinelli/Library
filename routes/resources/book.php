<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('livros')->group(function() {

    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/criar', [BookController::class, 'create'])->name('books.create');
    Route::get('/{book}/editar/', [BookController::class, 'edit'])->name('books.edit');

    Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.delete');

    Route::post('/', [BookController::class, 'insert'])->name('books.insert');
    Route::put('/', [BookController::class, 'update'])->name('books.update');

});