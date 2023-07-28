<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        // Create a new token for the user
        $token = $user->createToken('createdTokens')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        // Return a success response with user data and token
        return response($response, 201);
    }

    // Login user
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Find the user with the provided email
        $user = User::where('email', $fields['email'])->first();

        // Check if user exists and verify the password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong Login Credentials'
            ], 401);
        }

        // Create a new token for the user
        $token = $user->createToken('createdTokens')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        // Return a success response with user data and token
        return response($response, 201);
    }

    // Logout user
    public function logout(Request $request)
    {
        // Clear user tokens from the database
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out successfully'
        ];
    }
}
