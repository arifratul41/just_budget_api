<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->accessToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        Log::info('User:', [$user]);

        if (!$user || !Hash::check($request->password, $user->password)) {
            Log::info('Password:', [$request->password]);
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
    //
}
