<?php

namespace App\Http\Controllers;

use App\DTO\AdminMemberResponse;
use App\DTO\BookCopyResponse;
use App\DTO\member\MemberResponse;
use App\DTO\UserBookCopyResponse;
use App\DTO\UserMemberResponse;
use App\Models\Borrow;
use App\Models\Member;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\alert;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
       try {
           $members = Member::all();



           $membersResponse = $members->map(function ($member) {
               return new MemberResponse(
                   $member->user_id,
                   $member->id,
                   $member->first_name,
                   $member->last_name,
                   $member->email,
                   $member->phone,
                   $member->address,
                   $member->date_of_birth,
                   $member->membership_start_date,
                   $member->membership_end_date,
                   $member->picture,
                   $member->reservations->count(),
                   $member->borrows->count(),
               );
           });

           return response()->json($membersResponse, 200);

       } catch (\Throwable $th) {
           return response()->json([
               'message' => 'Error while getting members',
               'error' => $th->getMessage()
           ], 500);
       }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|unique:members',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:members',
                'phone' => 'required|string',
                'address' => 'required|string',
                'date_of_birth' => 'required|date',
                'membership_start_date' => 'required|date',
                'membership_end_date' => 'required|date',
            ]);

            $user = User::findOrFail($request->user_id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

            $member = Member::create($request->all());

            $memberResponse = new MemberResponse(
                $member->user_id,
                $member->id,
                $member->first_name,
                $member->last_name,
                $member->email,
                $member->phone,
                $member->address,
                $member->date_of_birth,
                $member->membership_start_date,
                $member->membership_end_date,
                $member->picture,
                $member->reservations->count(),
                $member->borrows->count(),
            );


            return response()->json($memberResponse, 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while creating member',
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
            $member = Member::find($id);

            if (!$member) {
                return response()->json([
                    'message' => 'Member not found'
                ], 404);
            }

            $memberResponse = new MemberResponse(
                $member->user_id,
                $member->id,
                $member->first_name,
                $member->last_name,
                $member->email,
                $member->phone,
                $member->address,
                $member->date_of_birth,
                $member->membership_start_date,
                $member->membership_end_date,
                $member->picture,
                $member->reservations->count(),
                $member->borrows->count(),
            );

            return response()->json($memberResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting member',
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
            $member = Member::find($id);

            if (!$member) {
                return response()->json([
                    'message' => 'Member not found'
                ], 404);
            }

            $request->validate([
                'user_id' => 'sometimes|required|integer|unique:members,user_id,' . $id,
                'first_name' => 'sometimes|required|string',
                'last_name' => 'sometimes|required|string',
                'email' => 'sometimes|required|email|unique:members,email,' . $id,
                'phone' => 'sometimes|required|string',
                'address' => 'sometimes|required|string',
                'date_of_birth' => 'sometimes|required|date',
                'membership_start_date' => 'sometimes|required|date',
                'membership_end_date' => 'sometimes|required|date',
            ]);

            $member->update($request->all());

            $memberResponse = new MemberResponse(
                $member->user_id,
                $member->id,
                $member->first_name,
                $member->last_name,
                $member->email,
                $member->phone,
                $member->address,
                $member->date_of_birth,
                $member->membership_start_date,
                $member->membership_end_date,
                $member->picture,
                $member->reservations->count(),
                $member->borrows->count(),
            );

            return response()->json($memberResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while updating member',
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
            $member = Member::find($id);

            if (!$member) {
                return response()->json([
                    'message' => 'Member not found'
                ], 404);
            }

            $borrows = $member->borrows;


            if ($borrows->count() > 0) {
                if ($borrows->where('status', 'borrowed')->count() > 0 || $borrows->where('status', 'overdue')->count() > 0) {
                    return response()->json([
                        'message' => 'Member has borrowed books'
                    ], 400);
                } else {
                    $borrows->map(function ($borrow) {
                        $borrow->delete();
                    });
                }
            }

            $reservations = $member->reservations;

            $reservations->map(function ($reservation) {
                $reservation->delete();
            });



            $member->delete();

            return response()->json([
                'message' => 'Member deleted successfully'
            ], 204);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while deleting member',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function createMember($data, $user_id) {
        $member = new Member();
        $member->first_name = $data->first_name;
        $member->last_name = $data->last_name;
        $member->email = $data->email;
        $member->phone = $data->phone;
        $member->address = $data->address;
        $member->date_of_birth = $data->date_of_birth;
        $member->membership_start_date = date('Y-m-d');
        $member->membership_end_date = date('Y-m-d', strtotime('+1 year'));
        $member->user_id = $user_id;
        $member->save();
    }
}
