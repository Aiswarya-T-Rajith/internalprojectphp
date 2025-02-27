<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UsersData;
use App\Models\EmployeeDetail;
use App\Models\FinancialDetail;
use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\Validator;

class CreateAdminController extends Controller
{
    public function createAdmin(Request $request){

        // return response()->json($request->all());

        //validation 
         $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,employee,superadmin',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male, female, other',
            'marital_status' => 'required|in:single, married, divorced, widowed',
            'nationality' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'permanent_address' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'employee_status' => 'required|in:On-boarding,Working,Left',
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'employment_type' => 'required|in:Permanent,Contract,Intern',
            'date_of_joining' => 'required|date|before_or_equal:today',
            'reporting_manager' => 'required|string|max:255',
            'work_location' => 'required|string|max:255',
            'bank_account_number' => 'nullable|string|max:20',
            'ifsc_code' => 'nullable|string|max:11',
            'pan_card_number' => 'nullable|string|max:10',
            'UAN' => 'nullable|string|max:12',
            'document_file_path' => 'nullable|file|mimes:pdf,jpeg,png,docx|max:10240', // Ensure valid document format and size
            'document_type' => 'required|string|max:255',
            'document_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try{

            //Insert into Users table
            $login = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role ?? 'admin'
            ]);

            //Insert into users_table
            $user = UsersData::create([
                'full_name' => $request->full_name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'nationality' => $request->nationality,
                'phone_number' => $request->phone_number,
                'permanent_address' => $request->permanent_address,
                'current_address' => $request->current_address,
                'employee_status' => $request->employee_status,
                'user_id' => $login->user_id
            ]);

            // Insert into employee_details
            $employee = EmployeeDetail::create([
                'user_details_id' => $user->user_details_id,
                'designation' => $request->designation,
                'department' => $request->department,
                'employement_type' => $request->employment_type,
                'date_of_joining' => $request->date_of_joining,
                'reporting_manager' => $request->reporting_manager,
                'work_location' => $request->work_location
            ]);

            // Insert into financial_details
            $financial = FinancialDetail::create([
                'emp_id' => $employee->emp_id,
                'bank_account_number' => $request->bank_account_number,
                'ifsc_code' => $request->ifsc_code,
                'pan_card_number' => $request->pan_card_number,
                'UAN' => $request->UAN
            ]);

            // Handle file upload
            if ($request->hasFile('document_file_path')) {
                $documentPath = $request->file('document_file_path')->store('uploads/documents', 'public');
            } else {
                $documentPath = null;
            }

            // Insert into employee_documents
            $document = EmployeeDocument::create([
                'emp_id' => $employee->emp_id,
                'document_type' => $request->document_type,
                'document_name' => $request->document_name,
                'document_file_path' => $documentPath
            ]);

            DB::commit();

            return response()->json(['message' => 'Employee record added successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
