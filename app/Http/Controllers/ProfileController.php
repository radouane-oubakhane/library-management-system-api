<?php

namespace App\Http\Controllers;

use App\DTO\profile\adminProfile\AdminProfileDashboardDataResponse;
use App\DTO\profile\adminProfile\AdminProfileInscriptionResponse;
use App\DTO\profile\adminProfile\AdminProfileResponse;
use App\DTO\profile\memberProfile\MemberProfileBookResponse;
use App\DTO\profile\memberProfile\MemberProfileBorrowResponse;
use App\DTO\profile\memberProfile\MemberProfileCategoryResponse;
use App\DTO\profile\memberProfile\MemberProfileReservationResponse;
use App\DTO\profile\memberProfile\MemberProfileResponse;
use App\DTO\profile\ProfileResponse;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Inscription;
use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(): JsonResponse
    {
        try {

        if (!Auth::user()->is_admin) {
            $member = Member::where('user_id', Auth::user()->id)->first();

            $reservations = $member->reservations;

            $borrows = $member->borrows;

            $memberProfileResponse = new MemberProfileResponse(
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
                $reservations->map(function ($reservation) {
                    return new MemberProfileReservationResponse(
                        $reservation->id,
                        new MemberProfileBookResponse(
                            $reservation->book->id,
                            $reservation->book->title,
                            $reservation->book->author->first_name,
                            $reservation->book->author->last_name,
                            new MemberProfileCategoryResponse(
                                $reservation->book->bookCategory->id,
                                $reservation->book->bookCategory->name,
                                $reservation->book->bookCategory->description,
                                $reservation->book->bookCategory->picture,
                            ),
                            $reservation->book->isbn,
                            $reservation->book->description,
                            $reservation->book->stock,
                            $reservation->book->publisher,
                            $reservation->book->published_at,
                            $reservation->book->language,
                            $reservation->book->edition,
                            $reservation->book->picture,
                        ),
                        $reservation->reserved_at,
                        $reservation->canceled_at,
                        $reservation->expired_at,
                        $reservation->status,
                    );
                })->toArray() ?? [],
                $borrows->map(function ($borrow) {
                    return new MemberProfileBorrowResponse(
                        $borrow->id,
                        new MemberProfileBookResponse(
                            $borrow->book->id,
                            $borrow->book->title,
                            $borrow->book->author->first_name,
                            $borrow->book->author->last_name,
                            new MemberProfileCategoryResponse(
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

                        $borrow->borrow_date,
                        $borrow->return_date,
                        $borrow->status,
                    );
                })->toArray() ?? [],
            );

            return response()->json($memberProfileResponse, 200);


        } elseif (Auth::user()->is_admin)
        {
            $member = Member::where('user_id', Auth::user()->id)->first();

            $inscriptions = Inscription::where('status', 'pending')->get();

            $books_count = Book::all()->count();
            $authors_count = Book::all()->count();
            $categories_count = BookCategory::all()->count();
            $members_count = Member::all()->count();
            $reservations_count = Reservation::where('status', 'reserved')->count();
            $borrows_count = Reservation::where('status', 'borrowed')->count();
            $inscriptions_count = Inscription::where('status', 'pending')->count();


            $adminProfileResponse = new AdminProfileResponse(
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
                $inscriptions->map(function ($inscription) {
                    return new AdminProfileInscriptionResponse(
                        $inscription->id,
                        $inscription->first_name,
                        $inscription->last_name,
                        $inscription->email,
                        $inscription->phone,
                        $inscription->address,
                        $inscription->date_of_birth,
                        $inscription->status,
                        $inscription->picture,
                    );
                })->toArray() ?? [],
                new AdminProfileDashboardDataResponse(
                    $books_count,
                    $authors_count,
                    $categories_count,
                    $members_count,
                    $reservations_count,
                    $borrows_count,
                    $inscriptions_count,
                ),
            );


            return response()->json($adminProfileResponse, 200);

        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error while fetching profile', 'error' => $th->getMessage()], 500);
        }
    }

    public function updateProfile(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'email' => 'sometimes|email',
                'password' => 'sometimes|string',

                'first_name' => 'sometimes|string',
                'last_name' => 'sometimes|string',
                'phone' => 'sometimes|string',
                'address' => 'sometimes|string',
                'date_of_birth' => 'sometimes|date',
                'membership_start_date' => 'sometimes|date',
                'membership_end_date' => 'sometimes|date',
            ]);


            $member = Member::where('user_id', Auth::user()->id)->first();

            if (!$member) {
                return response()->json(['message' => 'Member not found'], 404);
            }


            if ($request->has('password')) {
                $validatedData['password'] = bcrypt($request->password);
            }



            $member->update($validatedData);

            $user = Auth::user();

            $user->update($validatedData);

            $profileResponse = new ProfileResponse(
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
            );

            return response()->json($profileResponse, 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error while updating profile', 'error' => $th->getMessage()], 500);
        }
    }

    public function destroyProfile(): JsonResponse
    {
        try {
            $member = Member::where('user_id', Auth::user()->id)->first();

            if (!$member) {
                return response()->json(['message' => 'Member not found'], 404);
            }

            $member->reservations()->delete();
            $member->borrows()->delete();

            $member->delete();

            $user = Auth::user();

            $user->currentAccessToken()->delete();

            $user->delete();

            return response()->json(['message' => 'Profile deleted successfully'], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error while deleting profile', 'error' => $th->getMessage()], 500);
        }
    }


    public function updateImage(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'picture' => 'required|image',
            ]);

            $member = Member::where('user_id', Auth::user()->id)->first();

            if (!$member) {
                return response()->json(['message' => 'Member not found'], 404);
            }

            if ($request->hasFile('picture')) {
                // delete old image
                $image_path = public_path().'/storage/members/'.$member->picture;

                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                // upload new image
                $file = $request->file('picture');
                $fileName = $this->str_slug($member->first_name) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/members', $fileName);

                $validatedData['picture'] = $fileName;

                $member->update($validatedData);

            }

            $profileResponse = new ProfileResponse(
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
            );

            return response()->json($profileResponse, 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error while updating profile image', 'error' => $th->getMessage()], 500);
        }
    }

    private function str_slug(mixed $name)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }
}


