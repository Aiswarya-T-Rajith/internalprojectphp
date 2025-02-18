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
    public function user(){
        return $this -> belongsTo(UsersData::class, 'user_details_id', 'user_details_id');
    }
}
