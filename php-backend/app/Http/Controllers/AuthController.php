<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login API
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $credentials = $request->only('email_id', 'password');

        // Find user by user_id
        $user = User::where('email_id', $request->email_id)->first();

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
                'email_id' => $user->email_id,
                'role' => $user->role,
            ],
        ]);
    }
}