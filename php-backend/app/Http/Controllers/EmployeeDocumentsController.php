<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EmployeeDocumentsController extends Controller
{
    public function insertDocument(Request $request, $emp_id){

        $validator = Validator::make($request->all(),[
            'documents_section' => 'required|array'
        ]);

        // Validate each value inside 'documents_section'
        foreach ($request->documents_section as $key => $value) {
            if (empty($value)) { 
                $validator->errors()->add("documents_section.$key", "The $key field cannot be empty.");
            } elseif(!filter_var($value, FILTER_VALIDATE_URL)  && !preg_match('/^[a-zA-Z0-9\/._-]+$/', $value)) {
                $validator->errors()->add("documents_section.$key", "The $key field must be a valid URL.");
            }
        }

        if($validator->fails()){
            return response()->json(['error'=>'Enter a valid data','message' => $validator->errors()],422);
        }

        $employeeId = EmployeeDocument::where('emp_id',$emp_id)->first();

        if(!$employeeId){
            return response()->json(['error'=>'User not found'],404);
        }

         // Convert existing JSON field to an array
         $existingDocuments = json_decode($employeeId->documents_section, true) ?? [];

         // Find duplicate document names
         $duplicates = array_intersect_key($existingDocuments, $request->documents_section);
 
         if (!empty($duplicates)) {
             return response()->json([
                 'error' => 'The following documents are already uploaded',
                 'duplicate_documents' => array_keys($duplicates)
             ], 400);
         }
 
         // Merge new documents
         $updatedDocuments = array_merge($existingDocuments, $request->documents_section);
 
         // Update record
         $employeeId->update([
             'documents_section' => $updatedDocuments
         ]);
 
         return response()->json(['success' => 'Documents inserted successfully'], 200);
    }



    public function updateDocument(Request $request, $emp_id){
        $validator = Validator::make($request->all(),[
            'documents_section' => 'required|array'
        ]);

        Log::info($request->all());

        // Validate each value inside 'documents_section'
        foreach ($request->documents_section as $key => $value) {
            
            Log::info("Processing document: $key => " . json_encode($value));
            if (empty($value)) {  
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => ["documents_section.$key" => "The $key field cannot be empty."]
                ], 422);
            } elseif(!filter_var($value, FILTER_VALIDATE_URL)  && !preg_match('/^[a-zA-Z0-9\/._-]+$/', $value)) {
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => ["documents_section.$key" => "The $key field must be a valid URL."]
                ], 422);
            }
        }

        if($validator->fails()){
            return response()->json(['error'=>'Enter a valid data','message' => $validator->errors()],422);
        }

        $employeeId = EmployeeDocument::where('emp_id',$emp_id)->first();

        if(!$employeeId){
            return response()->json(['error'=>'User not found'],404);
        }

         // Convert the stored JSON into an array
        $existingDocuments = json_decode($employeeId->documents_section, true) ?? [];

        // Ensure both are arrays before using array_diff_key
        $missingKeys = array_diff_key($request->documents_section, $existingDocuments);

        if (!empty($missingKeys)) {
            return response()->json([
                'error' => 'The following document keys were not found',
                'missing_documents' => array_keys($missingKeys)
            ], 400);
        }

        // Update existing keys
        $updatedDocuments = array_merge($existingDocuments, $request->documents_section);

        // Save updated data
        $employeeId->update([
            'documents_section' => json_encode($updatedDocuments, JSON_UNESCAPED_SLASHES)
        ]);

        return response()->json(['success' => 'Documents updated successfully'], 200);

    }
}
