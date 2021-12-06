<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'attendance',
        'payment',
        'description',
    ];

    public function employee_attendances()
    {
        return $this->hasMany(EmployeeAttendance::class, 'attendance_id', 'id');
    }

    
    public function scopeWhereAttendance($query)
    {
        return $query->where('type', 'attendance');
    }
    
    public function scopeWhereLeave($query)
    {
        return $query->where('type', 'leave');
    }
}
