<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;



Route::get('/', [HomeController::class, 'getHome'])->name('home');
Route::get('/queryExample/{id?}', [HomeController::class, 'queryExample'])->name('home.queryExample');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

   Route::get('/dashboard', [HomeController::class, 'getHome'])->name('dashboard');
 
        Route::get('/', function () {
            if(!auth()->check()){
                return redirect()->route('login');
            }
            return redirect()->route('dashboard');
        })->name('home');

    
    Route::group(['middleware' => ['role:admin']], function () {
        
        Route::name('book.')->prefix('book')->group(function () {
            Route::get('/form/{bookId?}', [BookController::class, 'viewForm'])->name('form');
            Route::post('/create', [BookController::class, 'createBook'])->name('create');
            Route::put('/edit/{bookId}', [BookController::class, 'editBook'])->name('edit');

            Route::get('/delete/{bookId}', [BookController::class, 'deleteBook'])->name('delete');
        });
        
    });

    Route::get('/book/list', [BookController::class, 'index'])->name('book.index');
    Route::get('/book/details/{bookId}', [BookController::class, 'details'])->name('book.details');

    // 4. La Dashboard predefinita di Jetstream
    //Route::get('/dashboard', function () {
    //    return view('dashboard');
    //})->name('dashboard');


    
});





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