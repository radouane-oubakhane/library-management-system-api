<?php

namespace App\Http\Controllers;

use App\DTO\author\AuthorCategoryResponse;
use App\DTO\author\AuthorResponse;
use App\DTO\author\AuthorBookResponse;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try {
            $authors = Author::all();

            $authorsResponse = $authors->map(function ($author) {
                return new AuthorResponse(
                    $author->id,
                    $author->first_name,
                    $author->last_name,
                    $author->email,
                    $author->phone,
                    $author->address,
                    $author->date_of_birth,
                );
            });

            return response()->json($authorsResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting authors',
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
    public function store(Request $request):JsonResponse
    {

        try {

            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'address' => 'required|string',
                'date_of_birth' => 'required|date',
            ]);

            $author = Author::create($request->all());

            $authorResponse = new AuthorResponse(
                $author->id,
                $author->first_name,
                $author->last_name,
                $author->email,
                $author->phone,
                $author->address,
                $author->date_of_birth,
            );



            return response()->json($authorResponse, 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while creating author',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $author = Author::find($id);

            if (!$author) {
                return response()->json([
                    'message' => 'Author not found',
                ], 404);
            }

            $authorResponse = new AuthorResponse(
                $author->id,
                $author->first_name,
                $author->last_name,
                $author->email,
                $author->phone,
                $author->address,
                $author->date_of_birth,
            );

            return response()->json($authorResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting author',
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
    public function update(Request $request, string $id):JsonResponse
    {
        try {

            $request->validate([
                'first_name' => 'sometimes|required|string',
                'last_name' => 'sometimes|required|string',
                'email' => 'sometimes|required|email',
                'phone' => 'sometimes|required|string',
                'address' => 'sometimes|required|string',
                'date_of_birth' => 'sometimes|required|date',
            ]);

            $author = Author::findOrFail($id);

            if (!$author) {
                return response()->json([
                    'message' => 'Author not found',
                ], 404);
            }

            $author->update($request->all());

            $authorResponse = new AuthorResponse(
                $author->id,
                $author->first_name,
                $author->last_name,
                $author->email,
                $author->phone,
                $author->address,
                $author->date_of_birth,
            );

            return response()->json($authorResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while updating author',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        try {
            $author = Author::findOrFail($id);

            if (!$author) {
                return response()->json([
                    'message' => 'Author not found',
                ], 404);
            }

            $books = $author->books;

            $books->map(function ($book) {
                $book->author_id = null;
            });

            $author->delete();

            return response()->json(null, 204);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while deleting author',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function books(string $id):JsonResponse
    {
        try {
            $author = Author::findOrFail($id);


            if (!$author) {
                return response()->json([
                    'message' => 'Author not found',
                ], 404);
            }


            $books = $author->books->map(function ($book) {
                return new AuthorBookResponse(
                    $book->id,
                    $book->title,
                    new AuthorCategoryResponse(
                        $book->bookCategory->id,
                        $book->bookCategory->name,),
                    $book->isbn,
                    $book->description,
                    $book->stock,
                    $book->publisher,
                    $book->published_at,
                    $book->language,
                    $book->edition,
                );

            });

            return response()->json($books, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting author books',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
