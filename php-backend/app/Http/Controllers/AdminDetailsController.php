<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDetailsController extends Controller
{
    public function getAllAdmins(){
        $admins = User::where('role','=','admin')
        ->with([
            'userDetails',
            'userDetails.employeeDetail',
            'userDetails.employeeDetail.financialDetails',
            'userDetails.employeeDetail.employeeDocuments'
        ])
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $admins
        ],200);
    }
}
