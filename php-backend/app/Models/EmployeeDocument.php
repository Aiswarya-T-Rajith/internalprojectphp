<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDocument extends Model
{
    use HasFactory;
    protected $table = 'employee_documents';
    protected $primaryKey = 'documents_id';
    public $timestamps = true;
    protected $fillable = [
        'document_type', 'document_name', 'document_file_path', 'emp_id'
    ];
    public function user(){
        return $this -> belongsTo(FinancialDetail::class, 'emp_id', 'emp_id');
    }
}
