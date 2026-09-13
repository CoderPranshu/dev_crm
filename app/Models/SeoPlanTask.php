<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoPlanTask extends Model
{
    use HasFactory;

        protected $fillable = [
        'seo_plan_id',
        'day',
        'task_title',
        'sort_order',
        'status',
        'repeat_type',
    ];

    public function plan()
    {
        return $this->belongsTo(SeoPlan::class, 'seo_plan_id');
    }

    public function teamItems()
{
    return $this->hasMany(SeoTeamTaskItem::class, 'seo_plan_task_id');
}

}
