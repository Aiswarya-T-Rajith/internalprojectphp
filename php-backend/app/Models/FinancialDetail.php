<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialDetail extends Model
{
    use HasFactory;
    protected $table = 'financial_details';
    protected $primaryKey = 'finance_id';
    public $timestamps = true;
    protected $fillable = [
        'bank_account_number', 'ifsc_code', 'pan_card_number', 'UAN',
        'emp_id'
    ];
    /**
     * Relationship: Many FinancialDetails belong to one EmployeeDetail
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeDetail::class, 'emp_id', 'emp_id');
    }
}
