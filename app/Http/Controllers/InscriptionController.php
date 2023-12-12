<?php

namespace App\Http\Controllers;

use App\DTO\inscription\InscriptionResponse;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Inscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try {
        $inscriptions = Inscription::all();

        $inscriptionsResponse = $inscriptions->map(function ($inscription) {
            return new InscriptionResponse(
                $inscription->id,
                $inscription->first_name,
                $inscription->last_name,
                $inscription->email,
                $inscription->phone,
                $inscription->address,
                $inscription->date_of_birth,
                $inscription->status
            );
        });

        return response()->json($inscriptionsResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting inscriptions',
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
    public function store(Request $request)
    {

            try {
                $inscription = Inscription::create($request->all());

                return response()->json($inscription, 201);

            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Error while creating inscription',
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
            $inscription = Inscription::find($id);

            $inscriptionResponse = new InscriptionResponse(
                $inscription->id,
                $inscription->first_name,
                $inscription->last_name,
                $inscription->email,
                $inscription->phone,
                $inscription->address,
                $inscription->date_of_birth,
                $inscription->status
            );

            return response()->json($inscriptionResponse, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while getting inscription',
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
            $inscription = Inscription::find($id);

            $inscription->update($request->all());

            return response()->json($inscription, 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while updating inscription',
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
            Inscription::destroy($id);

            return response()->json([
                'message' => 'Inscription deleted'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while deleting inscription',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function accept(string $id):JsonResponse
    {
        try {
            $inscription = Inscription::find($id);

            $inscription->update([
                'status' => 'accepted'
            ]);

            $user = new RegisterController();
            $user->create($inscription);

            return response()->json([
                'message' => 'Inscription accepted'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while accepting inscription',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function reject(string $id):JsonResponse
    {
        try {
            $inscription = Inscription::find($id);

            $inscription->update([
                'status' => 'rejected'
            ]);

            return response()->json([
                'message' => 'Inscription rejected'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error while rejecting inscription',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
