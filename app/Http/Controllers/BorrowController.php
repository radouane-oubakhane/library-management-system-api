<?php

namespace App\Http\Controllers;

use App\DTO\BorrowResponse;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrows = Borrow::all();

        $borrows->map(function ($borrow) {
            return new BorrowResponse(
                $borrow->id,
                $borrow->book->title,
                $borrow->book->isbn,
                $borrow->bookCopy->id,
                $borrow->member->first_name,
                $borrow->member->last_name,
                $borrow->borrow_date,
                $borrow->return_date,
                $borrow->status,
            );
        });

        return view('borrows', [
            'borrows' => $borrows
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add-borrow');
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

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('edit-borrow', [
            'borrow' => Borrow::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->delete();
        return redirect()->route('borrows.index');
    }

    public function return(string $id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->status = 'returned';
        $borrow->save();
        return redirect()->route('borrows.index');
    }

    public function overdue(string $id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->status = 'overdue';
        $borrow->save();
        return redirect()->route('borrows.index');
    }
}
