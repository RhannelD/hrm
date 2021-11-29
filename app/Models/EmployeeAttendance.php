<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAttendance extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'attendance_id',
        'description',
        'start_at',
        'end_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'id');
    }

    public function get_number_of_days()
    {
        $date_start_at = Carbon::parse($this->start_at);
        $date_end_at   = Carbon::parse($this->end_at);

        return $date_start_at->diffInDays($date_end_at)+1;
    }
}
