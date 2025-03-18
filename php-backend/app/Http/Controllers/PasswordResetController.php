<?php

namespace App\Http\Controllers;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    /**
     * Send password reset link.
    */
    public function sendResetLink(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ],
    [
        'email.exists' => 'User not found',
    ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }

        try {
            $status = Password::sendResetLink($request->only('email'));
    
            // Fetch the user to get the email
            $user = User::where('email', $request->email)->first();
    
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
    
            // Generate frontend reset link
            $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
    
            if (!$token) {
                return response()->json(['error' => 'Reset token not found'], 400);
            }
    
            $resetUrl = "http://localhost:3001/ResetPassword?token=$token&email=" . urlencode($user->email);

             // Send custom notification
            $user->notify(new ResetPasswordNotification($token, $user->email));

    
            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Mail sent successfully', 'reset_link' => $resetUrl], 200)
                : response()->json(['error' => __($status)], 400);
        }catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'min:8',
                'confirmed'            
            ],
        ],[
        'email.exists' => 'This email is not registered in our system.',
        'password.min' => 'The password must be at least 8 characters long.',
        'password.confirmed' => 'The password confirmation does not match.'        
        ]);

        // **Check if validation fails and return errors**
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try{
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->password = Hash::make($password);
                    $user->save();
                    event(new PasswordReset($user));
                }
            );
    
            return $status === Password::PASSWORD_RESET
                ? response()->json(['message' => 'Password reset successful.'])
                : response()->json(['error' => __($status)], 400);
            }catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }

    }
}