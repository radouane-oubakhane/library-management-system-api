<?php

namespace App\Http\Controllers;

use App\DTO\user\UserResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name'=>['required','string','max:255'],
            'email'=>['required','string','email','max:255','unique:users'],
            'password'=>['required','string','min:8','confirmed'],
            'role'=>['required','string','max:255', 'in:admin,member']
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken : '.$user->email)->plainTextToken;

        $userResponse = new UserResponse(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            role: $user->role,
        );

        return response()->json(['user'=>$userResponse,'access_token'=>$accessToken],201);
    }

    public function login(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'email'=>['required','string','email','max:255'],
            'password'=>['required','string','min:8'],
        ]);

        if (!auth()->attempt($validatedData)) {
            return response()->json(['message'=>'Invalid credentials'],401);
        }


        $accessToken = auth()->user()->createToken('authToken : '.auth()->user()->email)->plainTextToken;

        $userResponse = new UserResponse(
            id: auth()->user()->id,
            name: auth()->user()->name,
            email: auth()->user()->email,
            role: auth()->user()->role,
        );

        return response()->json(['user'=>$userResponse,'access_token'=>$accessToken]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out successfully']);
    }

    public function refresh(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        $accessToken = auth()->user()->createToken('authToken : '.auth()->user()->email)->plainTextToken;

        return response()->json(['user'=>auth()->user(),'access_token'=>$accessToken]);
    }
}
