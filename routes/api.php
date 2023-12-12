<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCopyController;
use App\Http\Controllers\InscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('inscriptions')->group(function () {
    Route::get('/', [InscriptionController::class, 'index'])->name('inscriptions.index');
    Route::get('/{id}', [InscriptionController::class, 'show'])->name('inscriptions.show');
    Route::post('/', [InscriptionController::class, 'store'])->name('inscriptions.store');
    Route::put('/{id}', [InscriptionController::class, 'update'])->name('inscriptions.update');
    Route::delete('/{id}', [InscriptionController::class, 'destroy'])->name('inscriptions.destroy');
    Route::put('/{id}/accept', [InscriptionController::class, 'accept'])->name('inscriptions.accept');
    Route::put('/{id}/reject', [InscriptionController::class, 'reject'])->name('inscriptions.reject');
});


Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
    Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/{id}', [BookController::class, 'destroy'])->name('books.destroy');
});


Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/{id}', [AuthorController::class, 'show'])->name('authors.show');
    Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
    Route::put('/{id}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');

    Route::get('/{id}/books', [AuthorController::class, 'books'])->name('authors.books');
});


Route::prefix('categories')->group(function () {
    Route::get('/', [BookCategoryController::class, 'index'])->name('book-categories.index');
    Route::get('/{id}', [BookCategoryController::class, 'show'])->name('book-categories.show');
    Route::post('/', [BookCategoryController::class, 'store'])->name('book-categories.store');
    Route::put('/{id}', [BookCategoryController::class, 'update'])->name('book-categories.update');
    Route::delete('/{id}', [BookCategoryController::class, 'destroy'])->name('book-categories.destroy');

    Route::get('/{id}/books', [BookCategoryController::class, 'books'])->name('book-categories.books');
});

Route::prefix('book-copies')->group(function () {
    Route::get('/', [BookCopyController::class, 'index'])->name('book-copies.index');
    Route::get('/{id}', [BookCopyController::class, 'show'])->name('book-copies.show');
    Route::post('/', [BookCopyController::class, 'store'])->name('book-copies.store');
    Route::put('/{id}', [BookCopyController::class, 'update'])->name('book-copies.update');
    Route::delete('/{id}', [BookCopyController::class, 'destroy'])->name('book-copies.destroy');

    Route::get('/{id}/borrows', [BookCopyController::class, 'borrows'])->name('book-copies.borrows');
});
