<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;



Route::get('/', [HomeController::class, 'getHome'])->name('home');
Route::get('/queryExample/{id?}', [HomeController::class, 'queryExample'])->name('home.queryExample');


######## Routing diretto
// Route::get('/book-list', [BookController::class, 'index'])->name('book.index');
// Route::get('/book-details/{bookId}', [BookController::class, 'details'])->name('book.details');

// Route::get('/book-form/{bookId?}', [BookController::class, 'viewForm'])->name('book.form');


// Route::post('/book-create', [BookController::class, 'createBook'])->name('book.create');
// Route::put('/book-edit/{bookId}', [BookController::class, 'editBook'])->name('book.edit');
// Route::delete('/book-delete/{bookId}', [BookController::class, 'deleteBook'])->name('book.delete');

######## Routing with controller
// Route::controller(BookController::class)->group(function () {
//         Route::get('/book-list', 'index')->name('book.index');
//         Route::get('/book-details/{bookId}','details')->name('book.details');
//         Route::get('/book-form/{bookId?}', 'viewForm')->name('book.form');
//         Route::post('/book-create', 'createBook')->name('book.create');
//         Route::put('/book-edit/{bookId}', 'editBook')->name('book.edit');
//         Route::delete('/book-delete/{bookId}', 'deleteBook')->name('book.delete');

// });

  

// ######## Routing with groups and name
// http://127.0.0.1:8000/book/list
// route('book.index')

 Route::name('book.')->prefix('book')->group(function () {
    Route::get('/list', [BookController::class, 'index'])->name('index');
    Route::get('/details/{bookId}', [BookController::class, 'details'])->name('details');
    Route::get('/form/{bookId?}', [BookController::class, 'viewForm'])->name('form');
    Route::post('/create', [BookController::class, 'createBook'])->name('create');
    Route::put('/edit/{bookId}', [BookController::class, 'editBook'])->name('edit');
    Route::get('/delete/{bookId}', [BookController::class, 'deleteBook'])->name('delete');
});