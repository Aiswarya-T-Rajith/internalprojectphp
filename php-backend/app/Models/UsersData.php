<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UsersData extends Model
{
    use HasFactory;
    protected $table = 'users_table';
    protected $primaryKey = 'user_details_id';
    public $timestamps = true;
    protected $fillable = [
        'full_name', 'date_of_birth', 'gender', 'marital_status',
        'nationality', 'phone_number', 'permanent_address',
        'current_address', 'employee_status', 'user_id'
    ];
    public function user(){
        return $this -> belongsTo(User::class, 'user_id', 'user_id');
    }
}
