<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePosition extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'department_id',
        'position_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
