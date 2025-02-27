<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;
    protected $table = 'employee_details';
    protected $primaryKey = 'emp_id';
    public $timestamps = true;
    protected $fillable = [
        'designation', 'department', 'employement_type', 'date_of_joining',
        'reporting_manager', 'work_location', 'user_details_id'
    ];
    public function userDetails(){
        return $this -> belongsTo(UsersData::class, 'user_details_id', 'user_details_id');
    }

    /**
     * Relationship: One EmployeeDetail has Many EmployeeDocuments
     */
    public function employeeDocuments()
    {
        return $this->hasMany(EmployeeDocument::class, 'emp_id', 'emp_id');
    }

    /**
     * Relationship: One EmployeeDetail has Many FinancialDetails
     */
    public function financialDetails()
    {
        return $this->hasMany(FinancialDetail::class, 'emp_id', 'emp_id');
    }
}
