<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Exception;


class PasswordResetController extends Controller
{
    /**
     * Send password reset link.
    */
    public function sendResetLink(Request $request)
    {
        Log::info('Request data:', ['data' => $request->all()]);

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $status = Password::sendResetLink($request->only('email'));

            Log::info('Password reset email status:', ['status' => $status]);


            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Mail sent successfully'], 200)
                : response()->json(['error' => __($status)], 400);
        } catch (Exception $e) {
            Log::error('Error in sending password reset email:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function reset(Request $request)
    {
        Log::info('Password reset request received.', ['email' => $request->email, 'token' => $request->token]);

        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        try{
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->password = bcrypt($password);
                    $user->save();
                    event(new PasswordReset($user));
                }
            );

            Log::info('Password reset status:', ['status' => $status]);
    
            return $status === Password::PASSWORD_RESET
                ? response()->json(['message' => 'Password reset successful.'])
                : response()->json(['error' => __($status)], 400);
            }catch (Exception $e) {
            Log::error('Error in password reset:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }

    }
}