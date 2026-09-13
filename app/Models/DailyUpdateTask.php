<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyUpdateTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'task_date',
        'task_time',
        'priority',
        'status',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // protected $casts = [
    //     'task_date' => 'date',
    //     'task_time' => 'datetime:H:i',
    // ];

    protected $casts = [
        'task_date' => 'date',
    ];
}