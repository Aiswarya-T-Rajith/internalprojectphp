<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SinleUserDetailsController extends Controller
{
    public function getSingleUserDetaile($user_id){
        $singleUserDetails = User::where('user_id','=',$user_id)
        ->with([
            'userDetails',
            'userDetails.employeeDetail',
            'userDetails.employeeDetail.financialDetails',
            'userDetails.employeeDetail.employeeDocuments'
        ])
        ->first();

        if (!$singleUserDetails) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found or unauthorized access'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $singleUserDetails
        ],200);
    }
}
