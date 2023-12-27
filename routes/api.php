<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCopyController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
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





// =========================================== Public routes ===========================================

// login and register routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::prefix('inscriptions')->group(function () {
    Route::post('/', [InscriptionController::class, 'store'])->name('inscriptions.store');
});


Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
});


Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/{id}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('/{id}/books', [AuthorController::class, 'books'])->name('authors.books');
});


Route::prefix('categories')->group(function () {
    Route::get('/', [BookCategoryController::class, 'index'])->name('book-categories.index');
    Route::get('/{id}', [BookCategoryController::class, 'show'])->name('book-categories.show');
    Route::get('/{id}/books', [BookCategoryController::class, 'books'])->name('book-categories.books');
});


// =========================================== Protected routes ===========================================

// Admin routes
Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {


    // Inscriptions routes
    Route::prefix('inscriptions')->group(function () {
        Route::get('/', [InscriptionController::class, 'index'])->name('inscriptions.index');
        Route::get('/{id}', [InscriptionController::class, 'show'])->name('inscriptions.show');
        // Route::post('/', [InscriptionController::class, 'store'])->name('inscriptions.store');
        Route::put('/{id}', [InscriptionController::class, 'update'])->name('inscriptions.update');
        Route::delete('/{id}', [InscriptionController::class, 'destroy'])->name('inscriptions.destroy');

        Route::put('/{id}/accept', [InscriptionController::class, 'accept'])->name('inscriptions.accept');
        Route::put('/{id}/reject', [InscriptionController::class, 'reject'])->name('inscriptions.reject');
    });

    // Books routes
    Route::prefix('books')->group(function () {
        // Route::get('/', [BookController::class, 'index'])->name('books.index');
        // Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
        Route::post('/{id}/picture', [BookController::class, 'updateImage'])->name('book-categories.update-image');
        Route::delete('/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    // Authors routes
    Route::prefix('authors')->group(function () {
        // Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
        // Route::get('/{id}', [AuthorController::class, 'show'])->name('authors.show');
        Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
        Route::put('/{id}', [AuthorController::class, 'update'])->name('authors.update');
        Route::post('/{id}/picture', [AuthorController::class, 'updateImage'])->name('authors.update-image');
        Route::delete('/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');

        // Route::get('/{id}/books', [AuthorController::class, 'books'])->name('authors.books');
    });

    // Book categories routes
    Route::prefix('categories')->group(function () {
        // Route::get('/', [BookCategoryController::class, 'index'])->name('book-categories.index');
        // Route::get('/{id}', [BookCategoryController::class, 'show'])->name('book-categories.show');
        Route::post('/', [BookCategoryController::class, 'store'])->name('book-categories.store');
        Route::put('/{id}', [BookCategoryController::class, 'update'])->name('book-categories.update');
        Route::post('/{id}/picture', [BookCategoryController::class, 'updateImage'])->name('book-categories.update-image');
        Route::delete('/{id}', [BookCategoryController::class, 'destroy'])->name('book-categories.destroy');

        // Route::get('/{id}/books', [BookCategoryController::class, 'books'])->name('book-categories.books');
    });

    // Book copies routes
    Route::prefix('book-copies')->group(function () {
        Route::get('/', [BookCopyController::class, 'index'])->name('book-copies.index');
        Route::get('/{id}', [BookCopyController::class, 'show'])->name('book-copies.show');
        Route::post('/', [BookCopyController::class, 'store'])->name('book-copies.store');
        Route::put('/{id}', [BookCopyController::class, 'update'])->name('book-copies.update');
        Route::delete('/{id}', [BookCopyController::class, 'destroy'])->name('book-copies.destroy');

        Route::get('/{id}/borrows', [BookCopyController::class, 'borrows'])->name('book-copies.borrows');
    });

    // Borrows routes
    Route::prefix('borrows')->group(function () {
        Route::get('/', [BorrowController::class, 'index'])->name('borrows.index');
        Route::get('/{id}', [BorrowController::class, 'show'])->name('borrows.show');
        Route::post('/', [BorrowController::class, 'store'])->name('borrows.store');
        Route::put('/{id}', [BorrowController::class, 'update'])->name('borrows.update');
        Route::delete('/{id}', [BorrowController::class, 'destroy'])->name('borrows.destroy');

        Route::put('/{id}/return', [BorrowController::class, 'return'])->name('borrows.return');
        Route::put('/{id}/overdue', [BorrowController::class, 'overdue'])->name('borrows.overdue');
    });

    // Member routes
    Route::prefix('members')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('members.index');
        Route::get('/{id}', [MemberController::class, 'show'])->name('members.show');
        Route::post('/', [MemberController::class, 'store'])->name('members.store');
        Route::put('/{id}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

        Route::get('/{id}/borrows', [MemberController::class, 'borrows'])->name('members.borrows');
    });

    // Reservations routes
    Route::prefix('reservations')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/{id}', [ReservationController::class, 'show'])->name('reservations.show');
        // Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
        Route::put('/{id}', [ReservationController::class, 'update'])->name('reservations.update');
        // Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

        Route::put('/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
        Route::put('/{id}/borrow', [ReservationController::class, 'borrow'])->name('reservations.borrow');
    });

});

// Member routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'profile'])->name('profile');
        Route::put('/', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/picture', [ProfileController::class, 'updateImage'])->name('profile.update-image');
        Route::delete('/', [ProfileController::class, 'destroyProfile'])->name('profile.destroy');
    });

    // Reservations routes
    Route::prefix('reservations')->group(function () {
        Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
        Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    });



});


