<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateAdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route to create a Super Admin
Route::get('/createsuperadmin', [SuperAdminController::class, 'createSuperAdmin']);

//Route for Login
Route::post('/login',[AuthController::class, 'login']);

//Route for creating admin
Route::post('/createadmin',[CreateAdminController::class,'createAdmin']);