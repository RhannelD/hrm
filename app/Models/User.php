<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'usertype',
        'firstname',
        'lastname',
        'gender',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function employee_position()
    {
        return $this->hasOne(EmployeePosition::class, 'user_id', 'id');
    }


    public function is_admin()
    {
        return $this->usertype == 'adm';
    }

    public function can_payroll()
    {
        return EmployeePosition::where('user_id', $this->id)->where('position_id', 1)->exists();
    }

    public function flname()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function scopeWhereSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('email', 'like', "%$search%")
                ->orWhere(DB::raw('CONCAT(firstname, " ", lastname)'), 'like', "%$search%");
        });
    }

    public function scopeWhereEmployee($query)
    {
        return $query->where('usertype', 'emp');
    }
}
