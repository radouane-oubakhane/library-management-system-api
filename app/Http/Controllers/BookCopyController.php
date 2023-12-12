<?php

namespace App\Http\Controllers;

use App\DTO\BookCopyResponse;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookCopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $books = Book::all();


        $book_copies = $books->map(function ($book) {
            $reservation_count = Reservation::where('book_id', $book->id)->count();
            $borrow_count = DB::table('borrows')
                ->join('book_copies', 'book_copies.id', '=', 'borrows.book_copy_id')
                ->where('book_copies.book_id', '=', $book->id)
                ->count();
            $available_count = $book->stock - $reservation_count - $borrow_count;
            return new BookCopyResponse(
                $book->id,
                $book->title,
                $book->author ? $book->author->first_name : '',
                $book->author ? $book->author->last_name : '',
                $book->bookCategory ? $book->bookCategory->name : '',
                $book->stock,
                $reservation_count,
                $borrow_count,
                $available_count,
            );
        });

        return view('book-copies', [
            'bookCopies' => $book_copies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
