<?php

namespace App\Http\Controllers;

use App\DTO\borrow\BorrowCategoryResponse;
use App\DTO\reservation\ReservationBookResponse;
use App\DTO\reservation\ReservationMemberResponse;
use App\DTO\reservation\ReservationResponse;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $reservations = Reservation::all();

            $reservationsResponse = $reservations->map(function ($reservation) {
                return new ReservationResponse(
                    $reservation->id,
                    new ReservationMemberResponse(
                        $reservation->member->id,
                        $reservation->member->first_name,
                        $reservation->member->last_name,
                        $reservation->member->email,
                        $reservation->member->phone,
                        $reservation->member->address,
                        $reservation->member->date_of_birth,
                        $reservation->member->membership_start_date,
                        $reservation->member->membership_end_date,
                    ),
                    new ReservationBookResponse(
                        $reservation->book->id,
                        $reservation->book->title,
                        $reservation->book->author->first_name,
                        $reservation->book->author->last_name,
                        new BorrowCategoryResponse(
                            $reservation->book->bookCategory->id,
                            $reservation->book->bookCategory->name,
                        ),
                        $reservation->book->isbn,
                        $reservation->book->description,
                        $reservation->book->stock,
                        $reservation->book->publisher,
                        $reservation->book->published_at,
                        $reservation->book->language,
                        $reservation->book->edition,
                    ),
                    $reservation->reserved_at,
                    $reservation->canceled_at,
                    $reservation->expired_at,
                    $reservation->status
                );
            });

            return response()->json($reservationsResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting reservations',
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
                'member_id' => 'required|integer',
                'book_id' => 'required|integer',
                'reserved_at' => 'required|date',
                'canceled_at' => 'nullable|date',
                'expired_at' => 'nullable|date',
            ]);

            $request->merge([
                'status' => 'reserved'
            ]);

            $reservation = Reservation::create($request->all());

            $reservationResponse = new ReservationResponse(
                $reservation->id,
                new ReservationMemberResponse(
                    $reservation->member->id,
                    $reservation->member->first_name,
                    $reservation->member->last_name,
                    $reservation->member->email,
                    $reservation->member->phone,
                    $reservation->member->address,
                    $reservation->member->date_of_birth,
                    $reservation->member->membership_start_date,
                    $reservation->member->membership_end_date,
                ),
                new ReservationBookResponse(
                    $reservation->book->id,
                    $reservation->book->title,
                    $reservation->book->author->first_name,
                    $reservation->book->author->last_name,
                    new BorrowCategoryResponse(
                        $reservation->book->bookCategory->id,
                        $reservation->book->bookCategory->name,
                    ),
                    $reservation->book->isbn,
                    $reservation->book->description,
                    $reservation->book->stock,
                    $reservation->book->publisher,
                    $reservation->book->published_at,
                    $reservation->book->language,
                    $reservation->book->edition,
                ),
                $reservation->reserved_at,
                $reservation->canceled_at,
                $reservation->expired_at,
                $reservation->status
            );

            return response()->json($reservationResponse, 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while creating reservation',
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
            $reservation = Reservation::find($id);

            if (!$reservation) {
                return response()->json([
                    'message' => 'Reservation not found'
                ], 404);
            }

            $reservationResponse = new ReservationResponse(
                $reservation->id,
                new ReservationMemberResponse(
                    $reservation->member->id,
                    $reservation->member->first_name,
                    $reservation->member->last_name,
                    $reservation->member->email,
                    $reservation->member->phone,
                    $reservation->member->address,
                    $reservation->member->date_of_birth,
                    $reservation->member->membership_start_date,
                    $reservation->member->membership_end_date,
                ),
                new ReservationBookResponse(
                    $reservation->book->id,
                    $reservation->book->title,
                    $reservation->book->author->first_name,
                    $reservation->book->author->last_name,
                    new BorrowCategoryResponse(
                        $reservation->book->bookCategory->id,
                        $reservation->book->bookCategory->name,
                    ),
                    $reservation->book->isbn,
                    $reservation->book->description,
                    $reservation->book->stock,
                    $reservation->book->publisher,
                    $reservation->book->published_at,
                    $reservation->book->language,
                    $reservation->book->edition,
                ),
                $reservation->reserved_at,
                $reservation->canceled_at,
                $reservation->expired_at,
                $reservation->status
            );

            return response()->json($reservationResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting reservation',
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
            $reservation = Reservation::find($id);

            if (!$reservation) {
                return response()->json([
                    'message' => 'Reservation not found'
                ], 404);
            }

            $request->validate([
                'member_id' => 'sometimes|required|integer',
                'book_id' => 'sometimes|required|integer',
                'reserved_at' => 'sometimes|required|date',
                'canceled_at' => 'sometimes|nullable|date',
                'expired_at' => 'sometimes|nullable|date',
            ]);

            $reservation->update($request->all());

            $reservationResponse = new ReservationResponse(
                $reservation->id,
                new ReservationMemberResponse(
                    $reservation->member->id,
                    $reservation->member->first_name,
                    $reservation->member->last_name,
                    $reservation->member->email,
                    $reservation->member->phone,
                    $reservation->member->address,
                    $reservation->member->date_of_birth,
                    $reservation->member->membership_start_date,
                    $reservation->member->membership_end_date,
                ),
                new ReservationBookResponse(
                    $reservation->book->id,
                    $reservation->book->title,
                    $reservation->book->author->first_name,
                    $reservation->book->author->last_name,
                    new BorrowCategoryResponse(
                        $reservation->book->bookCategory->id,
                        $reservation->book->bookCategory->name,
                    ),
                    $reservation->book->isbn,
                    $reservation->book->description,
                    $reservation->book->stock,
                    $reservation->book->publisher,
                    $reservation->book->published_at,
                    $reservation->book->language,
                    $reservation->book->edition,
                ),
                $reservation->reserved_at,
                $reservation->canceled_at,
                $reservation->expired_at,
                $reservation->status
            );

            return response()->json($reservationResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while updating reservation',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $reservation = Reservation::find($id);

            if (!$reservation) {
                return response()->json([
                    'message' => 'Reservation not found'
                ], 404);
            }

            $reservation->delete();

            return response()->json([
                'message' => 'Reservation deleted'
            ], 204);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while deleting reservation',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function cancel(string $id): JsonResponse
    {
        try {
            $reservation = Reservation::find($id);

            if (!$reservation) {
                return response()->json([
                    'message' => 'Reservation not found'
                ], 404);
            }

            $reservation->update([
                'status' => 'canceled',
                'canceled_at' => now()
            ]);

            $reservationResponse = new ReservationResponse(
                $reservation->id,
                new ReservationMemberResponse(
                    $reservation->member->id,
                    $reservation->member->first_name,
                    $reservation->member->last_name,
                    $reservation->member->email,
                    $reservation->member->phone,
                    $reservation->member->address,
                    $reservation->member->date_of_birth,
                    $reservation->member->membership_start_date,
                    $reservation->member->membership_end_date,
                ),
                new ReservationBookResponse(
                    $reservation->book->id,
                    $reservation->book->title,
                    $reservation->book->author->first_name,
                    $reservation->book->author->last_name,
                    new BorrowCategoryResponse(
                        $reservation->book->bookCategory->id,
                        $reservation->book->bookCategory->name,
                    ),
                    $reservation->book->isbn,
                    $reservation->book->description,
                    $reservation->book->stock,
                    $reservation->book->publisher,
                    $reservation->book->published_at,
                    $reservation->book->language,
                    $reservation->book->edition,
                ),
                $reservation->reserved_at,
                $reservation->canceled_at,
                $reservation->expired_at,
                $reservation->status
            );

            return response()->json($reservationResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while canceling reservation',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function borrow(string $id): JsonResponse
    {
        try {
            $reservation = Reservation::find($id);

            if (!$reservation) {
                return response()->json([
                    'message' => 'Reservation not found'
                ], 404);
            }

            $reservation->update([
                'status' => 'borrowed',
                'canceled_at' => null
            ]);

            $reservationResponse = new ReservationResponse(
                $reservation->id,
                new ReservationMemberResponse(
                    $reservation->member->id,
                    $reservation->member->first_name,
                    $reservation->member->last_name,
                    $reservation->member->email,
                    $reservation->member->phone,
                    $reservation->member->address,
                    $reservation->member->date_of_birth,
                    $reservation->member->membership_start_date,
                    $reservation->member->membership_end_date,
                ),
                new ReservationBookResponse(
                    $reservation->book->id,
                    $reservation->book->title,
                    $reservation->book->author->first_name,
                    $reservation->book->author->last_name,
                    new BorrowCategoryResponse(
                        $reservation->book->bookCategory->id,
                        $reservation->book->bookCategory->name,
                    ),
                    $reservation->book->isbn,
                    $reservation->book->description,
                    $reservation->book->stock,
                    $reservation->book->publisher,
                    $reservation->book->published_at,
                    $reservation->book->language,
                    $reservation->book->edition,
                ),
                $reservation->reserved_at,
                $reservation->canceled_at,
                $reservation->expired_at,
                $reservation->status
            );

            return response()->json($reservationResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while reserving reservation',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
