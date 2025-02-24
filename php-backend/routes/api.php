<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateAdminController;
use App\Http\Controllers\PasswordResetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route to create a Super Admin
Route::get('/createsuperadmin', [SuperAdminController::class, 'createSuperAdmin']);

//Route for Login
Route::post('/login',[AuthController::class, 'login']);

//Route for creating admin
Route::post('/createadmin',[CreateAdminController::class,'createAdmin']);

// Forgot Password Route
Route::post('/forgotpassword', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

// Reset Password Route
Route::post('/resetpassword', [PasswordResetController::class, 'reset'])->name('password.reset');

// Define the password reset route explicitly
// Route::get('/reset-password/{token}', function ($token) {
//     return response()->json(['token' => $token]);
// })->name('password.reset');
