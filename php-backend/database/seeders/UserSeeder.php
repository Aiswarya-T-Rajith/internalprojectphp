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
                    'role' => 'admin',
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
                    'document_type' => 'On-boarding',
                    'document_name' => 'Aadhar',
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
                    'document_type' => 'Exit employee',
                    'document_name' => 'Employee ID',
                    'document_file_path' => 'assets/invoice.pdf'
                ],
                [
                    'email' => 'alice@gmail.com',
                    'password' => 'A@1234567',
                    'role' => 'employee',
                    'full_name' => 'Alice Smith',
                    'date_of_birth' => '1990-02-25',
                    'gender' => 'female',
                    'marital_status' => 'single',
                    'nationality' => 'Canadian',
                    'phone_number' => '9876543210',
                    'permanent_address' => '789 Main St, Toronto, Canada',
                    'current_address' => '456 Park Ave, Toronto, Canada',
                    'employee_status' => 'Working',
                    'designation' => 'Software Engineer',
                    'department' => 'IT',
                    'employment_type' => 'Permanent',
                    'date_of_joining' => '2019-07-15',
                    'reporting_manager' => 'CTO',
                    'work_location' => 'Toronto Office',
                    'bank_account_number' => '987654321098',
                    'ifsc_code' => 'IFSC5678',
                    'pan_card_number' => 'PAN7654321',
                    'UAN' => 'UAN0987654321',
                    'document_type' => 'On-boarding',
                    'document_name' => 'Aadhar',
                    'document_file_path' => 'assets/invoice.pdf'
                ],
                [
                    'email' => 'bob@gmail.com',
                    'password' => 'A@1234567',
                    'role' => 'employee',
                    'full_name' => 'Bob Johnson',
                    'date_of_birth' => '1988-11-10',
                    'gender' => 'male',
                    'marital_status' => 'married',
                    'nationality' => 'British',
                    'phone_number' => '8765432109',
                    'permanent_address' => '22 Oxford St, London, UK',
                    'current_address' => '10 Baker St, London, UK',
                    'employee_status' => 'Working',
                    'designation' => 'Project Manager',
                    'department' => 'Operations',
                    'employment_type' => 'Contract',
                    'date_of_joining' => '2021-03-20',
                    'reporting_manager' => 'COO',
                    'work_location' => 'London Office',
                    'bank_account_number' => '987654321098',
                    'ifsc_code' => 'IFSC8765',
                    'pan_card_number' => 'PAN8765432',
                    'UAN' => 'UAN8765432109',
                    'document_type' => 'Exit employee',
                    'document_name' => 'passport',
                    'document_file_path' => 'assets/invoice.pdf'
                ],
                [
                    'email' => 'charlie@gmail.com',
                    'password' => 'A@1234567',
                    'role' => 'employee',
                    'full_name' => 'Charlie Davis',
                    'date_of_birth' => '1995-09-05',
                    'gender' => 'male',
                    'marital_status' => 'single',
                    'nationality' => 'Australian',
                    'phone_number' => '7654321098',
                    'permanent_address' => '5 Sydney Road, Sydney, Australia',
                    'current_address' => '2 Harbor St, Sydney, Australia',
                    'employee_status' => 'Working',
                    'designation' => 'UI/UX Designer',
                    'department' => 'Design',
                    'employment_type' => 'Permanent',
                    'date_of_joining' => '2022-06-10',
                    'reporting_manager' => 'Head of Design',
                    'work_location' => 'Sydney Office',
                    'bank_account_number' => '765432109876',
                    'ifsc_code' => 'IFSC7654',
                    'pan_card_number' => 'PAN7654321',
                    'UAN' => 'UAN7654321098',
                    'document_type' => 'On-boarding',
                    'document_name' => 'Passport',
                    'document_file_path' => 'assets/invoice.pdf'
                ],
                [
                    'email' => 'diana@gmail.com',
                    'password' => 'A@1234567',
                    'role' => 'employee',
                    'full_name' => 'Diana Green',
                    'date_of_birth' => '1992-04-18',
                    'gender' => 'female',
                    'marital_status' => 'married',
                    'nationality' => 'Indian',
                    'phone_number' => '6543210987',
                    'permanent_address' =>'12 MG Road, Mumbai, India',
                    'current_address' => '34 Bandra St, Mumbai, India',
                    'employee_status' => 'Working',
                    'designation' =>  'HR Manager',
                    'department' => 'Human Resources',
                    'employment_type' => 'Permanent',
                    'date_of_joining' => '2018-05-22',
                    'reporting_manager' => 'CHRO',
                    'work_location' => 'Mumbai Office',
                    'bank_account_number' => '654321098765',
                    'ifsc_code' => 'IFSC6543',
                    'pan_card_number' => 'PAN6543210',
                    'UAN' => 'UAN6543210987',
                    'document_type' => 'On-boarding',
                    'document_name' => 'Latest Payslip',
                    'document_file_path' => 'assets/invoice.pdf'
                ],
                [
                    'email' => 'edward@gmail.com',
                    'password' => 'A@1234567',
                    'role' => 'employee',
                    'full_name' => 'Edward Wilson',
                    'date_of_birth' => '1987-12-30',
                    'gender' => 'male',
                    'marital_status' => 'single',
                    'nationality' => 'German',
                    'phone_number' => '5432109876',
                    'permanent_address' => '45 Berlin St, Berlin, Germany',
                    'current_address' => '90 Kreuzberg, Berlin, Germany',
                    'employee_status' => 'Working',
                    'designation' => 'Finance Analyst',
                    'department' => 'Finance',
                    'employment_type' => 'Contract',
                    'date_of_joining' => '2020-10-01',
                    'reporting_manager' => 'CFO',
                    'work_location' => 'Berlin Office',
                    'bank_account_number' => '543210987654',
                    'ifsc_code' => 'IFSC5432',
                    'pan_card_number' => 'PAN5432109',
                    'UAN' => 'UAN5432109876',
                    'document_type' => 'Exit employee',
                    'document_name' => 'Aadhar',
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
