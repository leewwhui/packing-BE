<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ['required', 'email', 'string'],
            "password" => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid Credentials',
                "errors" => [
                    "email" => "Invalid Credentials",
                    "password" => "Invalid Credentials"
                ]
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        return UserResource::make($user)->additional(["token" => $token, 'type' => 'login', 'code' => 200]);
    }

    public function register(Request $request)
    {
        $userAttributes = $request->validate([
            "name" => ["required", "string", "min:3", "max:255"],
            "email" => ["required", "email", "string", "unique:users,email"],
            "password" => ["required", "string", "min:8", "max:255", "confirmed"],
        ]);

        User::query()->create($userAttributes);

        return response()->json([
            "message" => "User created successfully"
        ]);
    }
}

