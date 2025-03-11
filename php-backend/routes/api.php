<?php

use App\Http\Controllers\AdminDetailsController;
use App\Http\Controllers\EmployeeCountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateAdminController;
use App\Http\Controllers\EmployeeDetailsController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\SinleUserDetailsController;
use App\Http\Controllers\EmployeeVerificationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route to create a Super Admin
Route::get('/createsuperadmin', [SuperAdminController::class, 'createSuperAdmin']);

//Route for Login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Forgot Password Route
Route::post('/forgotpassword', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

// Reset Password Route
Route::post('/resetpassword', [PasswordResetController::class, 'reset'])->name('password.reset');


Route::middleware(['auth:sanctum'])->group(function () {
    //Route for creating new user
    Route::post('/createadmin', [CreateAdminController::class, 'createAdmin']);


    //Get all user details Route
    Route::get('/getallusers', [UserDetailsController::class, 'getAllUsers']);

    //Get all admin details Route
    Route::get('/getalladmins', [AdminDetailsController::class, 'getAllAdmins']);

    //Get all employee details Route
    Route::get('/getallemployees', [EmployeeDetailsController::class, 'getAllEmployees']);

    //Get single user details
    Route::get('/getsingleuserdetails/{user_id}', [SinleUserDetailsController::class, 'getSingleUserDetaile']);

    //Document verification Route
    Route::post('/employeeverification/verify', [EmployeeVerificationController::class, 'updateVerification']);

    //Get the count of following, total employees, on-boarding, Exit employee
    Route::get('/employeecount', [EmployeeCountController::class, 'employeeCount']);
});
