<?php

namespace App\Http\Controllers;

use App\DTO\bookCopy\BookCopyCategoryResponse;
use App\DTO\bookCopy\BookCopyResponse;
use App\DTO\bookCopy\BookCopyBookResponse;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookCopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {

            $book_copies = BookCopy::all();

            $book_copy_responses = $book_copies->map(function ($book_copy) {
                return new BookCopyResponse(
                    $book_copy->id,
                    new BookCopyBookResponse(
                        $book_copy->book->id,
                        $book_copy->book->title,
                        $book_copy->book->author->first_name,
                        $book_copy->book->author->last_name,
                        new BookCopyCategoryResponse(
                            $book_copy->book->bookCategory->id,
                            $book_copy->book->bookCategory->name,
                            $book_copy->book->bookCategory->description,
                            $book_copy->book->bookCategory->picture,
                        ),
                        $book_copy->book->isbn,
                        $book_copy->book->description,
                        $book_copy->book->stock,
                        $book_copy->book->publisher,
                        $book_copy->book->published_at,
                        $book_copy->book->language,
                        $book_copy->book->edition,
                        $book_copy->book->picture,
                    ),
                    $book_copy->status,
                );
            });

            return response()->json($book_copy_responses, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting book copies',
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
                'book_id' => 'required|integer',
                'status' => 'required|string|in:available,borrowed',
            ]);

            $book = Book::find($request->book_id);

            if (!$book) {
                return response()->json([
                    'message' => 'Book not found',
                ], 404);
            }


            $book_copy = BookCopy::create([
                'book_id' => $request->book_id,
                'status' => $request->status,
            ]);

            // book stock is incremented by 1
            $book->increment('stock');



            return response()->json($book_copy, 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while creating book copy',
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

            $book_copy = BookCopy::find($id);

            if (!$book_copy) {
                return response()->json([
                    'message' => 'Book copy not found',
                ], 404);
            }

            $book_copy_response = new BookCopyResponse(
                $book_copy->id,
                new BookCopyBookResponse(
                    $book_copy->book->id,
                    $book_copy->book->title,
                    $book_copy->book->author->first_name,
                    $book_copy->book->author->last_name,
                    new BookCopyCategoryResponse(
                        $book_copy->book->bookCategory->id,
                        $book_copy->book->bookCategory->name,
                        $book_copy->book->bookCategory->description,
                        $book_copy->book->bookCategory->picture,
                    ),
                    $book_copy->book->isbn,
                    $book_copy->book->description,
                    $book_copy->book->stock,
                    $book_copy->book->publisher,
                    $book_copy->book->published_at,
                    $book_copy->book->language,
                    $book_copy->book->edition,
                    $book_copy->book->picture,
                ),
                $book_copy->status,
            );

            return response()->json($book_copy_response, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting book copy',
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
    public function update(Request $request, string $id): JsonResponse
    {
        try {

            $request->validate([
                'status' => 'required|string|in:available,borrowed',
            ]);

            $book_copy = BookCopy::find($id);

            if (!$book_copy) {
                return response()->json([
                    'message' => 'Book copy not found',
                ], 404);
            }

            $book_copy->update([
                'status' => $request->status,
            ]);

            $book_copy_response = new BookCopyResponse(
                $book_copy->id,
                new BookCopyBookResponse(
                    $book_copy->book->id,
                    $book_copy->book->title,
                    $book_copy->book->author->first_name,
                    $book_copy->book->author->last_name,
                    new BookCopyCategoryResponse(
                        $book_copy->book->bookCategory->id,
                        $book_copy->book->bookCategory->name,
                        $book_copy->book->bookCategory->description,
                        $book_copy->book->bookCategory->picture,
                    ),
                    $book_copy->book->isbn,
                    $book_copy->book->description,
                    $book_copy->book->stock,
                    $book_copy->book->publisher,
                    $book_copy->book->published_at,
                    $book_copy->book->language,
                    $book_copy->book->edition,
                    $book_copy->book->picture,
                ),
                $book_copy->status,
            );

            return response()->json($book_copy_response, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while updating book copy',
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

                $book_copy = BookCopy::find($id);

                if (!$book_copy) {
                    return response()->json([
                        'message' => 'Book copy not found',
                    ], 404);
                }

                $book_copy->delete();

                return response()->json([
                    'message' => 'Book copy deleted successfully',
                ], 204);

            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Error while deleting book copy',
                    'error' => $th->getMessage()
                ], 500);
        }
    }
}
