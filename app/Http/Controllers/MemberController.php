<?php

namespace App\Http\Controllers;

use App\DTO\AdminMemberResponse;
use App\DTO\BookCopyResponse;
use App\DTO\UserBookCopyResponse;
use App\DTO\UserMemberResponse;
use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\alert;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('members', [
            'members' => Member::all()
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::findOrFail($id);
        $user = $member->user;

        if ($user->role == 'user') {

            $borrows = DB::table('borrows')
                ->where('member_id', $id)
                ->where('status', 'borrowed')
                ->get();

            $reservations = Reservation::where('member_id', $id)
                ->where('status', 'reserved')
                ->get()
            );

            return view('user-profile', [
                'member' => $member_response


            ]);
        } elseif ($user->role == 'admin') {

            $member_response = new AdminMemberResponse(
                $member,
                $member->bookCopies->map(function ($bookCopy) {
                    return new BookCopyResponse(
                        $bookCopy->id,
                        $bookCopy->book->title,
                        $bookCopy->book->author->first_name,
                        $bookCopy->book->author->last_name,
                        $bookCopy->book->bookCategory->name,
                        $bookCopy->book->stock,
                        $bookCopy->reservations->count(),
                        $bookCopy->borrows->count(),
                        $bookCopy->book->stock - $bookCopy->reservations->count() - $bookCopy->borrows->count(),
                    );
                })
            );

            return view('member', [
                'member' => $member_response
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('edit-member', [
            'member' => Member::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $member->update($request->all());
        return redirect()->route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrows = \App\Models\Borrow::where('member_id', $id)->get();
        foreach ($borrows as $borrow) {
            $borrow->delete();
        }
        Member::destroy($id);
        return redirect()->route('members.index');
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
