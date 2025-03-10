<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Login API
     */

    public function login(Request $request)
    {
        //Ensures both email and password is provided
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Find user by user_id, fetches only the first matching record from the database.
        $user = User::where('email', $request->email)->first();


        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if user exists and password is correct
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        // Generate authentication token
        $token = $user->createToken('AuthToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }
}