<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeVerificationController extends Controller
{
    public function updateVerification(Request $request){

        $request -> validate([
            'emp_id' => 'required|exists:employee_documents,emp_id',
            'role'=>'required|in:admin,superadmin',
            'status'=>'required|in:approved,rejected',
            'comments'=>'nullable|string',
        ]);

        $document = EmployeeDocument::where('emp_id',$request->emp_id)->first();


        if ($request->role === 'admin') {
            if ($document->admin_verification_status !== 'pending') {
                return response()->json(['message' => 'Admin has already verified this document.'], 400);
            }

            $document->admin_verification_status = $request->status;
            $document->admin_verification_comments = $request->comments;
        } elseif ($request->role === 'superadmin') {
            if ($document->admin_verification_status !== 'approved') {
                return response()->json(['message' => 'Superadmin cannot verify until Admin approves.'], 400);
            }

            if ($document->superadmin_verification_status !== 'pending') {
                return response()->json(['message' => 'Superadmin has already verified this document.'], 400);
            }

            $document->superadmin_verification_status = $request->status;
            $document->superadmin_verification_comments = $request->comments;
        }

        Log::debug("Final document state after verification:", $document->toArray());
        $document->save();

        return response()->json(['message' => 'Verification status updated successfully.'], 200);
    }
}
