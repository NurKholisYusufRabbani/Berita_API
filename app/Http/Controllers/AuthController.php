<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|string|max:255|unique:users',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'message' => 'User registered successfully'
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'nullable|boolean',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if ($request->remember_me) {
                // Set token TTL 30 days if remember_me true
                JWTAuth::factory()->setTTL(60 * 24 * 30);
            } else {
                // Default 1 hour TTL
                JWTAuth::factory()->setTTL(60);
            }

            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            \Log::error('JWT Error: '.$e->getMessage());
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json(compact('token'));
    }

    // Get Authenticated User
    public function me()
    {
        try {
            $user = auth()->user();
            if (! $user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get user'], 500);
        }
    }

    // Logout - invalidate token
    public function logout()
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'User logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }
}
