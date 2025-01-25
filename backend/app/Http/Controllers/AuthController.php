<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate the incoming request data
            $registerdData = $request->validate([
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required|confirmed'
            ]);
        
            // Create a new user with the validated data
            $user = User::create($registerdData);
        
            // Generate the access token for the user
            $accessToken = $user->createToken('authToken')->accessToken;
        
            // Return the user data and access token in the response
            return response(['user' => $user, 'access_token' => $accessToken], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Let Laravel handle validation errors with a 422 status code
            throw $e;
        } catch (\Exception $e) {
            // Handle other exceptions and return a custom 400 error message
            return response()->json([
                'error' => 'Registration failed',
                'message' => $e->getMessage(),
            ], 400); 
        }
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (!auth()->attempt($loginData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $user = auth()->user();
        $accessToken = $user->createToken('authToken')->accessToken;
    
        return response()->json([
            'user' => $user,
            'access_token' => $accessToken,
        ]);
    }

    public function logout(Request $request)
    {
        // Revoke the user's token to log them out
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Successfully logged out']);
    }

}


