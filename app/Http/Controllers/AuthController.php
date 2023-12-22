<?php

namespace App\Http\Controllers;

use App\DTO\user\UserResponse;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'email'=>['required','string','email','max:255','unique:users'],
            'password'=>['required','string','min:8','confirmed'],
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData + ['is_admin'=>false]);

        $member = Member::where('user_id', Auth::user()->id)->first();

        $accessToken = $user->createToken('authToken : '.$user->email)->plainTextToken;

        $userResponse = new UserResponse(
            id: $user->id,
            email: $user->email,
            is_admin: $user->is_admin,
            first_name: $member->first_name,
            last_name: $member->last_name,
            picture: $member->picture,
            member_id: $member->id,
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

        $member = Member::where('user_id', Auth::user()->id)->first();

        $userResponse = new UserResponse(
            id: auth()->user()->id,
            email: auth()->user()->email,
            is_admin: auth()->user()->is_admin,
            first_name: $member->first_name,
            last_name: $member->last_name,
            picture: $member->picture,
            member_id: $member->id,
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
