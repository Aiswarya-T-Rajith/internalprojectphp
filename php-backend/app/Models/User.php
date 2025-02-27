<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users'; // Explicitly defining the table name

    protected $primaryKey = 'user_id'; // Set primary key to 'user_id'


    protected $fillable = [
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

     /**
     * Override method to use email_id for password reset.
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

     /**
     * Relationship: One User has One UsersData
     */
    public function userDetails()
    {
        return $this->hasOne(UsersData::class, 'user_id', 'user_id');
    }
}
