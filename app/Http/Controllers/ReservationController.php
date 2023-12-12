<?php

namespace App\Http\Controllers;

use App\DTO\ReservationResponse;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();

        $reservationResponse = $reservations->map(function ($reservation) {
            return new ReservationResponse(
                $reservation->id,
                $reservation->book->title,
                $reservation->book->isbn,
                $reservation->member->first_name,
                $reservation->member->last_name,
                $reservation->reserved_at,
                $reservation->canceled_at ?? '',
                $reservation->expired_at,
            );
        });

        return view('reservations', [
            'reservations' => $reservationResponse,
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservations.index');
    }
}
