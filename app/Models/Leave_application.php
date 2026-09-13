<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave_application extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'days', 'user_id', 'from_date', 'to_date', 'working_day', 'status', 'reason', 'attachment'    
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function leavetype()
    {
        return $this->belongsTo(LeaveType::class, 'reason');
    }
}
