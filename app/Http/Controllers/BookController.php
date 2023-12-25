<?php

namespace App\Http\Controllers;

use App\DTO\book\BookCategoryResponse;
use App\DTO\book\BookResponse;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $books = Book::all();

            $book_responses = $books->map(function ($book) {
                return new BookResponse(
                    $book->id,
                    $book->title,
                    $book->author->first_name,
                    $book->author->last_name,
                    new BookCategoryResponse(
                        $book->bookCategory->id,
                        $book->bookCategory->name,
                        $book->bookCategory->description,
                        $book->bookCategory->picture,),
                    $book->isbn,
                    $book->description,
                    $book->stock,
                    $book->publisher,
                    $book->published_at,
                    $book->language,
                    $book->edition,
                    $book->picture,
                );
            });

            return response()->json($book_responses, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting books',
                'error' => $th->getMessage()
            ], 500);
        }
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
    public function store(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'title' => 'required|string',
                'author_id' => 'required|integer',
                'book_category_id' => 'required|integer',
                'isbn' => 'required|string',
                'description' => 'required|string',
                'stock' => 'required|integer',
                'publisher' => 'required|string',
                'published_at' => 'required|date',
                'language' => 'required|string',
                'edition' => 'required|string',
            ]);

            $book = Book::create($request->all());

            $bookResponse = new BookResponse(
                $book->id,
                $book->title,
                $book->author->first_name,
                $book->author->last_name,
                new BookCategoryResponse(
                    $book->bookCategory->id,
                    $book->bookCategory->name,
                    $book->bookCategory->description,
                    $book->bookCategory->picture,),
                $book->isbn,
                $book->description,
                $book->stock,
                $book->publisher,
                $book->published_at,
                $book->language,
                $book->edition,
                $book->picture,
            );

            return response()->json($bookResponse, 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while creating book',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $book = Book::findOrFail($id);

            if (!$book) {
                return response()->json([
                    'message' => 'Book not found',
                ], 404);
            }

            $bookResponse = new BookResponse(
                $book->id,
                $book->title,
                $book->author->first_name,
                $book->author->last_name,
                new BookCategoryResponse(
                    $book->bookCategory->id,
                    $book->bookCategory->name,
                    $book->bookCategory->description,
                    $book->bookCategory->picture,),
                $book->isbn,
                $book->description,
                $book->stock,
                $book->publisher,
                $book->published_at,
                $book->language,
                $book->edition,
                $book->picture,
            );

            return response()->json($bookResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting book',
                'error' => $th->getMessage()
            ], 500);
        }
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
        try {

            $request->validate([
                'title' => 'sometimes|required|string',
                'author_id' => 'sometimes|required|integer',
                'book_category_id' => 'sometimes|required|integer',
                'isbn' => 'sometimes|required|string',
                'description' => 'sometimes|required|string',
                'stock' => 'sometimes|required|integer',
                'publisher' => 'sometimes|required|string',
                'published_at' => 'sometimes|required|date',
                'language' => 'sometimes|required|string',
                'edition' => 'sometimes|required|string',
            ]);

            $book = Book::findOrFail($id);

            if (!$book) {
                return response()->json([
                    'message' => 'Book not found',
                ], 404);
            }

            $book->update($request->all());

            $bookResponse = new BookResponse(
                $book->id,
                $book->title,
                $book->author->first_name,
                $book->author->last_name,
                new BookCategoryResponse(
                    $book->bookCategory->id,
                    $book->bookCategory->name,
                    $book->bookCategory->description,
                    $book->bookCategory->picture,),
                $book->isbn,
                $book->description,
                $book->stock,
                $book->publisher,
                $book->published_at,
                $book->language,
                $book->edition,
                $book->picture,
            );

            return response()->json($bookResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while updating book',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $book = Book::findOrFail($id);

            if (!$book) {
                return response()->json([
                    'message' => 'Book not found',
                ], 404);
            }


            $book->bookCopies->map(function ($bookCopy) {
                $bookCopy->delete();
            });

            $book->reservations->map(function ($reservation) {
                $reservation->delete();
            });

            $book->borrows->map(function ($borrow) {
                $borrow->delete();
            });



            $book->delete();

            return response()->json(null, 204);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while deleting book',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
