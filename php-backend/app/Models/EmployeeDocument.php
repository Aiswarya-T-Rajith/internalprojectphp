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
        'document_type', 'documents_section', 'emp_id', 'admin_verification_status', 'admin_verification_comments', 'admin_verified_at', 'superadmin_verification_status', 'superadmin_verification_comments', 'superadmin_verified_at'
    ];
     /**
     * Relationship: Many EmployeeDocuments belong to one EmployeeDetail
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeDetail::class, 'emp_id', 'emp_id');
    }

}
