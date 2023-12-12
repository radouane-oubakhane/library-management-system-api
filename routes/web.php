<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCopyController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});

// Books
Route::get('/books', [BookController::class, 'index'])->name('books.index');
// Members
//Route::get('/members', [MemberController::class, 'index'])->name('members.index');
//Route::get('/member/{id}', [MemberController::class, 'show'])->name('members.index');
// Inscriptions
//Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('inscriptions.index');
// BookReserve
// Route::get('/bookreserve', [BookCopyController::class, 'index'])->name('books reserve.index');
// Create Inscription
//Route::get('/inscriptions/create', [InscriptionController::class, 'create'])->name('inscriptions.create');
// Store Inscription
//Route::post('/inscriptions', [InscriptionController::class, 'store'])->name('inscriptions.store');


Route::prefix('inscriptions')->group(function () {
    Route::get('/', [InscriptionController::class, 'index'])->name('inscriptions.index');
    Route::get('/create', [InscriptionController::class, 'create'])->name('inscriptions.create');
    Route::post('/', [InscriptionController::class, 'store'])->name('inscriptions.store');
    Route::get('/{id}', [InscriptionController::class, 'show'])->name('inscriptions.show');
    Route::get('/{id}/edit', [InscriptionController::class, 'edit'])->name('inscriptions.edit');
    Route::post('/{id}/edit', [InscriptionController::class, 'update'])->name('inscriptions.update');
    Route::post('/{id}/delete', [InscriptionController::class, 'destroy'])->name('inscriptions.destroy');
    Route::post('/{id}/accept', [InscriptionController::class, 'accept'])->name('inscriptions.accept');
});


//Auteur
Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');

Route::post('/authors/store', [AuthorController::class, 'store'])->name('authors.store');

Route::prefix('book-categories')->group(function () {
    Route::get('/', [BookCategoryController::class, 'index'])->name('book-categories.index');
    Route::get('/create', [BookCategoryController::class, 'create'])->name('book-categories.create');
    Route::post('/', [BookCategoryController::class, 'store'])->name('book-categories.store');
    Route::get('/{id}/edit', [BookCategoryController::class, 'edit'])->name('book-categories.edit');
    Route::post('/{id}/edit', [BookCategoryController::class, 'update'])->name('book-categories.update');
    Route::post('/{id}/delete', [BookCategoryController::class, 'destroy'])->name('book-categories.destroy');

});

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
    Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::post('/{id}/edit', [BookController::class, 'update'])->name('books.update');
    Route::post('/{id}/delete', [BookController::class, 'destroy'])->name('books.destroy');
});



Route::prefix('members')->group(callback: function () {
    Route::get('/', [MemberController::class, 'index'])->name('members.index');
    Route::get('/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/', [MemberController::class, 'store'])->name('members.store');
    Route::get('/{id}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/{id}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::post('/{id}/edit', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/delete/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

});


Route::prefix("authors")->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/{id}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('/{id}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::post('/{id}/edit', [AuthorController::class, 'update'])->name('authors.update');
    Route::post('/{id}/delete', [AuthorController::class, 'destroy'])->name('authors.destroy');
});

Route::prefix("book-copies")->group(function () {
    Route::get('/', [BookCopyController::class, 'index'])->name('book-copies.index');
    Route::get('/create', [BookCopyController::class, 'create'])->name('book-copies.create');
    Route::post('/', [BookCopyController::class, 'store'])->name('book-copies.store');
    Route::get('/{id}', [BookCopyController::class, 'show'])->name('book-copies.show');
    Route::get('/{id}/edit', [BookCopyController::class, 'edit'])->name('book-copies.edit');
    Route::post('/{id}/edit', [BookCopyController::class, 'update'])->name('book-copies.update');
    Route::post('/{id}/delete', [BookCopyController::class, 'destroy'])->name('book-copies.destroy');
});

Route::prefix("borrows")->group(function () {
    Route::get('/', [BorrowController::class, 'index'])->name('borrows.index');
    Route::get('/create', [BorrowController::class, 'create'])->name('borrows.create');
    Route::post('/', [BorrowController::class, 'store'])->name('borrows.store');
    Route::get('/{id}', [BorrowController::class, 'show'])->name('borrows.show');
    Route::get('/{id}/edit', [BorrowController::class, 'edit'])->name('borrows.edit');
    Route::post('/{id}/edit', [BorrowController::class, 'update'])->name('borrows.update');
    Route::post('/{id}/delete', [BorrowController::class, 'destroy'])->name('borrows.destroy');


    Route::post('/{id}/return', [BorrowController::class, 'return'])->name('borrows.return');
    Route::post('/{id}/overdue', [BorrowController::class, 'overdue'])->name('borrows.overdue');
});

Route::prefix("reservations")->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::post('/{id}/edit', [ReservationController::class, 'update'])->name('reservations.update');
    Route::post('/{id}/delete', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::post('/{id}/expire', [ReservationController::class, 'expire'])->name('reservations.expire');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
