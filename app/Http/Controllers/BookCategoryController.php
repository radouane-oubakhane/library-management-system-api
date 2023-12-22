<?php

namespace App\Http\Controllers;

use App\DTO\category\CategoryBookResponse;
use App\DTO\category\CategoryResponse;
use App\Models\BookCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try {
            $categories = BookCategory::all();

            $categoriesResponse = $categories->map(function ($category) {
                return new CategoryResponse(
                    $category->id,
                    $category->name,
                    $category->description,
                    $category->picture,
                );
            })->toArray();

            return response()->json($categoriesResponse, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error while fetching categories',
                'error' => $e->getMessage()
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
                'name' => 'required|string',
                'description' => 'required|string',
                'picture' => 'required|string',
            ]);


            $category = BookCategory::create($request->all());

            $categoryResponse = new CategoryResponse(
                $category->id,
                $category->name,
                $category->description,
                $category->picture,
            );



            return response()->json($categoryResponse, 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error while creating category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResponse
    {
        try {
            $category = BookCategory::findOrFail($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                ], 404);
            }

            $categoryResponse = new CategoryResponse(
                $category->id,
                $category->name,
                $category->description,
                $category->picture,
            );

            return response()->json($categoryResponse, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error while fetching category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):JsonResponse
    {
        try {

            $request->validate([
                'name' => 'sometimes|string',
                'description' => 'sometimes|string',
                'picture' => 'sometimes|string',
            ]);

            $category = BookCategory::findOrFail($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                ], 404);
            }

            $category->update($request->all());

            $categoryResponse = new CategoryResponse(
                $category->id,
                $category->name,
                $category->description,
                $category->picture,
            );

            return response()->json($categoryResponse, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error while updating category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        try {
            $category = BookCategory::findOrFail($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                ], 404);
            }

            $category->books()->detach();

            $category->delete();

            return response()->json(null, 204);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error while deleting category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function books(string $id):JsonResponse
    {
        try {
            $category = BookCategory::findOrFail($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                ], 404);
            }

            $books = $category->books;

            $booksResponse = $books->map(function ($book) {
                return new CategoryBookResponse(
                    $book->id,
                    $book->title,
                    $book->isbn,
                    $book->description,
                    $book->stock,
                    $book->publisher,
                    $book->published_at,
                    $book->language,
                    $book->edition,
                    $book->picture,
                );
            })->toArray();

            return response()->json($booksResponse, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error while fetching books',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
