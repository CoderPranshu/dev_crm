<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoTeamTaskItem extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'seo_team_task_id',
    //     'seo_plan_task_id',
    //     'status',
    //     'completed_at',
    //     'remarks'
    // ];

    protected $fillable = [
        'seo_team_task_id',
        'seo_plan_task_id',
        'status',
        'completed_at',
        'remarks',
    ];

    public function teamTask()
    {
        return $this->belongsTo(SeoTeamTask::class, 'seo_team_task_id');
    }

    // public function planTask()
    // {
    //     return $this->belongsTo(SeoPlanTask::class, 'seo_plan_task_id');
    // }



    // public function seoTeamTask()
    // {
    //     return $this->belongsTo(SeoTeamTask::class);
    // }

    public function seoTeamTask()
    {
        return $this->belongsTo(SeoTeamTask::class);
    }

    public function planTask()
    {
        return $this->belongsTo(SeoPlanTask::class,'seo_plan_task_id');
    }
    

}
