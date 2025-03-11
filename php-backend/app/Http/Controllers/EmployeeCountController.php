<?php

namespace App\Http\Controllers;
use App\Models\UsersData;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;

class EmployeeCountController extends Controller
{
    public function EmployeeCount(){
        $totalEmployeeCount = UsersData::count();
        $onBoardingEmployeeCount = EmployeeDocument::where('document_type','On-boarding')->count();
        $exitEmployeeCount = EmployeeDocument::where('document_type','Exit employee')->count();

        return response()->json([
            'total_employees' => $totalEmployeeCount,
            'onboarding_employees' => $onBoardingEmployeeCount,
            'exit_employees' => $exitEmployeeCount
        ], 200);
    }
}
