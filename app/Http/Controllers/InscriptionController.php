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
    public function index(): JsonResponse
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
    public function store(Request $request): JsonResponse
    {

        try {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:inscriptions',
                'phone' => 'required|string',
                'address' => 'required|string',
                'date_of_birth' => 'required|date',
                'password' => 'required|string',
            ]);

            $request->merge([
                'status' => 'pending'
            ]);

            $inscription = Inscription::create($request->all());

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

            return response()->json($inscriptionResponse, 201);

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
    public function show(string $id): JsonResponse
    {
        try {
            $inscription = Inscription::find($id);

            if (!$inscription) {
                return response()->json([
                    'message' => 'Inscription not found'
                ], 404);
            }

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
    public function update(Request $request, string $id): JsonResponse
    {
        try {

            $request->validate([
                'first_name' => 'sometimes|required|string',
                'last_name' => 'sometimes|required|string',
                'email' => 'sometimes|required|email|unique:inscriptions',
                'phone' => 'sometimes|required|string',
                'address' => 'sometimes|required|string',
                'date_of_birth' => 'sometimes|required|date',
                'status' => 'sometimes|required|string',
                'password' => 'sometimes|required|string',
            ]);

            $inscription = Inscription::find($id);


            if (!$inscription) {
                return response()->json([
                    'message' => 'Inscription not found'
                ], 404);
            }

            $inscription->update($request->all());

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
                'message' => 'Error while updating inscription',
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
            $inscription = Inscription::find($id);

            if (!$inscription) {
                return response()->json([
                    'message' => 'Inscription not found'
                ], 404);
            }

            $inscription->delete();

            return response()->json([
                'message' => 'Inscription deleted'
            ], 204);

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

            if (!$inscription) {
                return response()->json([
                    'message' => 'Inscription not found'
                ], 404);
            }

            $inscription->update([
                'status' => 'accepted'
            ]);

            // $user = new RegisterController();
            // $user->create($inscription);

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
                'message' => 'Error while accepting inscription',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function reject(string $id):JsonResponse
    {
        try {
            $inscription = Inscription::find($id);

            if (!$inscription) {
                return response()->json([
                    'message' => 'Inscription not found'
                ], 404);
            }

            $inscription->update([
                'status' => 'rejected'
            ]);

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
                'message' => 'Error while rejecting inscription',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
