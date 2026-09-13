<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoTaskTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_plan_id',
        'day',
        'task_title',
        'description',
        'sort_order',
        'status',
    ];

    public function plan()
    {
        return $this->belongsTo(SeoPlan::class, 'seo_plan_id');
    }

    public function getDayNameAttribute()
    {
        return match ($this->day) {
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            default => '-',
        };
    }

}
