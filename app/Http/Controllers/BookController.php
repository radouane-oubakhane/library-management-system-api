<?php

namespace App\Http\Controllers;

use App\DTO\BookResponse;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return 'List of books from the database using the books model';

        $books = Book::all();

        $book_responses = $books->map(function ($book) {
            return new BookResponse(
                $book->id,
                $book->title,
                $book->author->first_name,
                $book->author->last_name,
                $book->bookCategory->name,
                $book->isbn,
                $book->description,
                $book->stock,
                $book->publisher,
                $book->published_at,
                $book->language,
                $book->edition,
            );
        });

        return view('books', [
            'books' => $book_responses
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add-book', [
            'authors' => Author::all(),
            'bookCategories' => BookCategory::all(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $book = Book::create($request->all());

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('book', [
            'book' => Book::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('edit-book', [
            'book' => Book::findOrFail($id),
            'authors' => Author::all(),
            'bookCategories' => BookCategory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $borrows = $book->borrows;
        $borrows->each(function ($borrow) {
            $borrow->update(['book_id' => null, 'book_copy_id' => null]);
        });
        $book->bookCopies()->delete();


        $book->bookCopies()->delete();
        $book->reservations()->delete();



        $book->delete();
        return redirect()->route('books.index');
    }
}
