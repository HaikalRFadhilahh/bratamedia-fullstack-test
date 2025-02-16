<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['statusCode' => 401, 'status' => "error", "message" => "Unauthorized"], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'message' => 'Login Success',
            'data' => $token
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['status' => 'success'], 200, ['Content-Type' => 'application/json']);
    }

    public function validate()
    {
        return response()->json(['statusCode' => 200, 'status' => 'success', 'message' => "Data Users", 'data' => collect(Auth::user())], 200, ['Content-Type', 'application/json']);
    }
}
