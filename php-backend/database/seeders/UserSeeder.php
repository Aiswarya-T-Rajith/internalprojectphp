<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UsersData;
use App\Models\EmployeeDetail;
use App\Models\FinancialDetail;
use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $users = [
                [
                    'email' => 'john@gmail.com',
                    'password' => 'A@1234567',
                    'role' => 'employee',
                    'full_name' => 'John',
                    'date_of_birth' => '1985-06-15',
                    'gender' => 'male',
                    'marital_status' => 'married',
                    'nationality' => 'American',
                    'phone_number' => '1234567890',
                    'permanent_address' => '123 Admin St, City, Country',
                    'current_address' => '456 Admin St, City, Country',
                    'employee_status' => 'Working',
                    'designation' => 'Administrator',
                    'department' => 'Management',
                    'employment_type' => 'Permanent',
                    'date_of_joining' => '2020-01-01',
                    'reporting_manager' => 'CEO',
                    'work_location' => 'Head Office',
                    'bank_account_number' => '123456789012',
                    'ifsc_code' => 'IFSC1234',
                    'pan_card_number' => 'PAN1234567',
                    'UAN' => 'UAN1234567890',
                    'document_type' => 'ID Proof',
                    'document_name' => 'Admin ID',
                    'document_file_path' => 'assets/invoice.pdf'
                ],
                [
                    'email' => 'Kevin@example.com',
                    'password' => 'A@1234567',
                    'role' => 'employee',
                    'full_name' => 'Kevin Doe',
                    'date_of_birth' => '1990-08-20',
                    'gender' => 'male',
                    'marital_status' => 'single',
                    'nationality' => 'American',
                    'phone_number' => '9876543210',
                    'permanent_address' => '789 Employee St, City, Country',
                    'current_address' => '101 Employee St, City, Country',
                    'employee_status' => 'Working',
                    'designation' => 'Software Engineer',
                    'department' => 'IT',
                    'employment_type' => 'Permanent',
                    'date_of_joining' => '2021-06-15',
                    'reporting_manager' => 'Admin User',
                    'work_location' => 'Branch Office',
                    'bank_account_number' => '987654321098',
                    'ifsc_code' => 'IFSC5678',
                    'pan_card_number' => 'PAN7654321',
                    'UAN' => 'UAN0987654321',
                    'document_type' => 'ID Proof',
                    'document_name' => 'Employee ID',
                    'document_file_path' => 'assets/invoice.pdf'
                ]
            ];

            foreach ($users as $userData) {
                $user = User::create([
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role']
                ]);

                $userDetails = UsersData::create([
                    'full_name' => $userData['full_name'],
                    'date_of_birth' => $userData['date_of_birth'],
                    'gender' => $userData['gender'],
                    'marital_status' => $userData['marital_status'],
                    'nationality' => $userData['nationality'],
                    'phone_number' => $userData['phone_number'],
                    'permanent_address' => $userData['permanent_address'],
                    'current_address' => $userData['current_address'],
                    'employee_status' => $userData['employee_status'],
                    'user_id' => $user->user_id
                ]);

                $employee = EmployeeDetail::create([
                    'user_details_id' => $userDetails->user_details_id,
                    'designation' => $userData['designation'],
                    'department' => $userData['department'],
                    'employement_type' => $userData['employment_type'],
                    'date_of_joining' => $userData['date_of_joining'],
                    'reporting_manager' => $userData['reporting_manager'],
                    'work_location' => $userData['work_location']
                ]);

                FinancialDetail::create([
                    'emp_id' => $employee->emp_id,
                    'bank_account_number' => $userData['bank_account_number'],
                    'ifsc_code' => $userData['ifsc_code'],
                    'pan_card_number' => $userData['pan_card_number'],
                    'UAN' => $userData['UAN']
                ]);

                EmployeeDocument::create([
                    'emp_id' => $employee->emp_id,
                    'document_type' => $userData['document_type'],
                    'document_name' => $userData['document_name'],
                    'document_file_path' => $userData['document_file_path']
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
