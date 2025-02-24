<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function createSuperAdmin(){
        // Check if a superadmin already exists
        $existingSuperAdmin = User::where('role', 'superadmin')->first();
        if ($existingSuperAdmin) {
            return response()->json(['message' => 'Super Admin already exists!'], 400);
        }
    
        //create a new superadmin user
        $superAdmin = User::create([
            'email' => 'aiswarya@pumexinfotech.com',
            'password'=> Hash::make('SuperAdmin@123'),
            'role'=>'superadmin',
        ]);
    
        return response()->json(['message' => 'Super Admin created successfully!', 'data' => $superAdmin], 201);

    }
}
