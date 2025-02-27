<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeDetailsController extends Controller
{
    public function getAllEmployees(){
        $employees = User::where('role','=','employee')
        ->with([
            'userDetails',
            'userDetails.employeeDetail',
            'userDetails.employeeDetail.financialDetails',
            'userDetails.employeeDetail.employeeDocuments'
        ])
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $employees 
        ],200);
    }
}
