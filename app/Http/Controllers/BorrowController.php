<?php

namespace App\Http\Controllers;

use App\DTO\borrow\BorrowBookResponse;
use App\DTO\borrow\BorrowCategoryResponse;
use App\DTO\borrow\BorrowMemberResponse;
use App\DTO\borrow\BorrowResponse;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrow;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $borrows = Borrow::all();

            $borrowsResponse = $borrows->map(function ($borrow) {
                return new BorrowResponse(
                    $borrow->id,
                    new BorrowBookResponse(
                        $borrow->book->id,
                        $borrow->book->title,
                        $borrow->book->author->first_name,
                        $borrow->book->author->last_name,
                        new BorrowCategoryResponse(
                            $borrow->book->bookCategory->id,
                            $borrow->book->bookCategory->name,
                            $borrow->book->bookCategory->description,
                            $borrow->book->bookCategory->picture,

                        ),
                        $borrow->book->isbn,
                        $borrow->book->description,
                        $borrow->book->stock,
                        $borrow->book->publisher,
                        $borrow->book->published_at,
                        $borrow->book->language,
                        $borrow->book->edition,
                        $borrow->book->picture,
                    ),
                    $borrow->book_copy_id,
                    new BorrowMemberResponse(
                        $borrow->member->id,
                        $borrow->member->first_name,
                        $borrow->member->last_name,
                        $borrow->member->email,
                        $borrow->member->phone,
                        $borrow->member->address,
                        $borrow->member->date_of_birth,
                        $borrow->member->membership_start_date,
                        $borrow->member->membership_end_date,
                        $borrow->member->picture,
                    ),
                    $borrow->borrow_date,
                    $borrow->return_date,
                    $borrow->status,
                );
            })->toArray();

            return response()->json($borrowsResponse, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error while fetching borrows',
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
    public function store(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'book_id' => 'required|integer',
                'book_copy_id' => 'required|integer',
                'member_id' => 'required|integer',
                'borrow_date' => 'required|date',
                'return_date' => 'required|date',
            ]);

            $book = Book::findOrFail($request->book_id);

            if (!$book) {
                return response()->json([
                    'message' => 'Book not found'
                ], 404);
            }

            $book_copy = BookCopy::findOrFail($request->book_copy_id);

            if (!$book_copy) {
                return response()->json([
                    'message' => 'Book copy not found'
                ], 404);
            }

            if ($book_copy->status == 'borrowed') {
                return response()->json([
                    'message' => 'Book copy already borrowed'
                ], 400);
            }

            $member = Member::findOrFail($request->member_id);

            if (!$member) {
                return response()->json([
                    'message' => 'Member not found'
                ], 404);
            }

            $request->merge([
                'status' => 'borrowed'
            ]);

            $borrow = Borrow::create($request->all());

            $book_copy->status = 'borrowed';
            $book_copy->save();


            $borrowResponse = new BorrowResponse(
                $borrow->id,
                new BorrowBookResponse(
                    $borrow->book->id,
                    $borrow->book->title,
                    $borrow->book->author->first_name,
                    $borrow->book->author->last_name,
                    new BorrowCategoryResponse(
                        $borrow->book->bookCategory->id,
                        $borrow->book->bookCategory->name,
                        $borrow->book->bookCategory->description,
                        $borrow->book->bookCategory->picture,

                    ),
                    $borrow->book->isbn,
                    $borrow->book->description,
                    $borrow->book->stock,
                    $borrow->book->publisher,
                    $borrow->book->published_at,
                    $borrow->book->language,
                    $borrow->book->edition,
                    $borrow->book->picture,
                ),
                $borrow->book_copy_id,
                new BorrowMemberResponse(
                    $borrow->member->id,
                    $borrow->member->first_name,
                    $borrow->member->last_name,
                    $borrow->member->email,
                    $borrow->member->phone,
                    $borrow->member->address,
                    $borrow->member->date_of_birth,
                    $borrow->member->membership_start_date,
                    $borrow->member->membership_end_date,
                    $borrow->member->picture,
                ),
                $borrow->borrow_date,
                $borrow->return_date,
                $borrow->status,
            );

            return response()->json($borrowResponse, 201);


        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while creating borrow',
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
            $borrow = Borrow::findOrFail($id);

            if (!$borrow) {
                return response()->json([
                    'message' => 'Borrow not found',
                ], 404);
            }

            $borrowResponse = new BorrowResponse(
                $borrow->id,
                new BorrowBookResponse(
                    $borrow->book->id,
                    $borrow->book->title,
                    $borrow->book->author->first_name,
                    $borrow->book->author->last_name,
                    new BorrowCategoryResponse(
                        $borrow->book->bookCategory->id,
                        $borrow->book->bookCategory->name,
                        $borrow->book->bookCategory->description,
                        $borrow->book->bookCategory->picture,
                    ),
                    $borrow->book->isbn,
                    $borrow->book->description,
                    $borrow->book->stock,
                    $borrow->book->publisher,
                    $borrow->book->published_at,
                    $borrow->book->language,
                    $borrow->book->edition,
                    $borrow->book->picture,
                ),
                $borrow->book_copy_id,
                new BorrowMemberResponse(
                    $borrow->member->id,
                    $borrow->member->first_name,
                    $borrow->member->last_name,
                    $borrow->member->email,
                    $borrow->member->phone,
                    $borrow->member->address,
                    $borrow->member->date_of_birth,
                    $borrow->member->membership_start_date,
                    $borrow->member->membership_end_date,
                    $borrow->member->picture,
                ),
                $borrow->borrow_date,
                $borrow->return_date,
                $borrow->status,
            );

            return response()->json($borrowResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while fetching borrow',
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
                'book_id' => 'sometimes|required|integer',
                'book_copy_id' => 'sometimes|required|integer',
                'member_id' => 'sometimes|required|integer',
                'borrow_date' => 'sometimes|required|date',
                'return_date' => 'sometimes|required|date',
                'status' => 'sometimes|required|string|in:borrowed,returned,overdue',
            ]);

            $borrow = Borrow::findOrFail($id);


            if (!$borrow) {
                return response()->json([
                    'message' => 'Borrow not found',
                ], 404);
            }

            $book_copy = BookCopy::findOrFail($request->book_copy_id);

            if (!$book_copy) {
                return response()->json([
                    'message' => 'Book copy not found'
                ], 404);
            }

            if ($request->status == 'returned') {
                $book_copy->status = 'available';
                $book_copy->save();
            }


            $borrow->update($request->all());

            $borrowResponse = new BorrowResponse(
                $borrow->id,
                new BorrowBookResponse(
                    $borrow->book->id,
                    $borrow->book->title,
                    $borrow->book->author->first_name,
                    $borrow->book->author->last_name,
                    new BorrowCategoryResponse(
                        $borrow->book->bookCategory->id,
                        $borrow->book->bookCategory->name,
                        $borrow->book->bookCategory->description,
                        $borrow->book->bookCategory->picture,
                    ),
                    $borrow->book->isbn,
                    $borrow->book->description,
                    $borrow->book->stock,
                    $borrow->book->publisher,
                    $borrow->book->published_at,
                    $borrow->book->language,
                    $borrow->book->edition,
                    $borrow->book->picture,
                ),
                $borrow->book_copy_id,
                new BorrowMemberResponse(
                    $borrow->member->id,
                    $borrow->member->first_name,
                    $borrow->member->last_name,
                    $borrow->member->email,
                    $borrow->member->phone,
                    $borrow->member->address,
                    $borrow->member->date_of_birth,
                    $borrow->member->membership_start_date,
                    $borrow->member->membership_end_date,
                    $borrow->member->picture,
                ),
                $borrow->borrow_date,
                $borrow->return_date,
                $borrow->status,
            );

            return response()->json($borrowResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while updating borrow',
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
            $borrow = Borrow::findOrFail($id);

            if (!$borrow) {
                return response()->json([
                    'message' => 'Borrow not found',
                ], 404);
            }

            $book_copy = BookCopy::findOrFail($borrow->book_copy_id);



            $borrow->delete();

            return response()->json([
                'message' => 'Borrow deleted successfully',
            ], 204);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while deleting borrow',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function return(string $id): JsonResponse
    {
           try {
                $borrow = Borrow::findOrFail($id);
                $borrow->status = 'returned';
                $borrow->return_date = now();
                $borrow->save();

                $book_copy = BookCopy::findOrFail($borrow->book_copy_id);
                $book_copy->status = 'available';
                $book_copy->save();

                $borrowResponse = new BorrowResponse(
                    $borrow->id,
                    new BorrowBookResponse(
                        $borrow->book->id,
                        $borrow->book->title,
                        $borrow->book->author->first_name,
                        $borrow->book->author->last_name,
                        new BorrowCategoryResponse(
                            $borrow->book->bookCategory->id,
                            $borrow->book->bookCategory->name,
                            $borrow->book->bookCategory->description,
                            $borrow->book->bookCategory->picture,
                        ),
                        $borrow->book->isbn,
                        $borrow->book->description,
                        $borrow->book->stock,
                        $borrow->book->publisher,
                        $borrow->book->published_at,
                        $borrow->book->language,
                        $borrow->book->edition,
                        $borrow->book->picture,
                    ),
                    $borrow->book_copy_id,
                    new BorrowMemberResponse(
                        $borrow->member->id,
                        $borrow->member->first_name,
                        $borrow->member->last_name,
                        $borrow->member->email,
                        $borrow->member->phone,
                        $borrow->member->address,
                        $borrow->member->date_of_birth,
                        $borrow->member->membership_start_date,
                        $borrow->member->membership_end_date,
                        $borrow->member->picture,
                    ),
                    $borrow->borrow_date,
                    $borrow->return_date,
                    $borrow->status,
                );

                return response()->json($borrowResponse, 200);

            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Error while returning borrow',
                    'error' => $th->getMessage()
                ], 500);
           }
    }

    public function overdue(string $id): JsonResponse
    {
              try {
                 $borrow = Borrow::findOrFail($id);

                 if ($borrow->status == 'returned') {
                     return response()->json([
                         'message' => 'Borrow already returned',
                     ], 400);
                 }

                 $borrow->status = 'overdue';
                 $borrow->save();



                 $borrowResponse = new BorrowResponse(
                        $borrow->id,
                        new BorrowBookResponse(
                            $borrow->book->id,
                            $borrow->book->title,
                            $borrow->book->author->first_name,
                            $borrow->book->author->last_name,
                            new BorrowCategoryResponse(
                                $borrow->book->bookCategory->id,
                                $borrow->book->bookCategory->name,
                                $borrow->book->bookCategory->description,
                                $borrow->book->bookCategory->picture,
                            ),
                            $borrow->book->isbn,
                            $borrow->book->description,
                            $borrow->book->stock,
                            $borrow->book->publisher,
                            $borrow->book->published_at,
                            $borrow->book->language,
                            $borrow->book->edition,
                            $borrow->book->picture,
                        ),
                        $borrow->book_copy_id,
                        new BorrowMemberResponse(
                            $borrow->member->id,
                            $borrow->member->first_name,
                            $borrow->member->last_name,
                            $borrow->member->email,
                            $borrow->member->phone,
                            $borrow->member->address,
                            $borrow->member->date_of_birth,
                            $borrow->member->membership_start_date,
                            $borrow->member->membership_end_date,
                            $borrow->member->picture,
                        ),
                        $borrow->borrow_date,
                        $borrow->return_date,
                        $borrow->status,
                    );

                    return response()->json($borrowResponse, 200);

                } catch (\Throwable $th) {
                 return response()->json([
                      'message' => 'Error while overdue borrow',
                      'error' => $th->getMessage()
                 ], 500);
              }
    }
}
