<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\Request;

class UserDetailsController extends Controller
{
    public function getAllUsers(){
        $users = User::where('role', '!=', 'superadmin')
        ->with([
                'userDetails',
                'userDetails.employeeDetail',
                'userDetails.employeeDetail.financialDetails',
                'userDetails.employeeDetail.employeeDocuments'
            ])
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);

    }
}
