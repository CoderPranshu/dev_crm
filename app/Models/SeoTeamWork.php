<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class SeoTeamWork extends Model
{
    use HasFactory;

    // protected $fillable = [

    //     'seo_team_task_item_id',

    //     'work_date',

    //     'status',

    //     'completed_at',

    //     'remarks',

    //     'attachment',

    // ];

    protected $fillable = [

        'seo_plan_client_id',
        'seo_plan_task_id',
        'work_date',
        'status',
        'completed_at',
        'team_id',
        'attachment',
        'remarks',
        'link',
        'seo_task_distribution_id',
    ];

    public function taskItem()
    {
        return $this->belongsTo(SeoTeamTaskItem::class, 'seo_team_task_item_id');
    }

    public function planClient()
    {
        return $this->belongsTo(SeoPlanClient::class,'seo_plan_client_id');
    }

    public function planTask()
    {
        return $this->belongsTo(SeoPlanTask::class,'seo_plan_task_id');
    }

    public function team()
    {
        return $this->belongsTo(User::class, 'team_id');
    }

    public function task()
    {
        return $this->belongsTo(
            SeoPlanTask::class,
            'seo_plan_task_id'
        );
    }


    // 


    public function seoPlanTask()
    {
        return $this->belongsTo(SeoPlanTask::class, 'seo_plan_task_id');
    }

    public function seoPlanClient()
    {
        return $this->belongsTo(SeoPlanClient::class, 'seo_plan_client_id');
    }

    public function distribution()
    {
        return $this->belongsTo(
            SeoTaskDistribution::class,
            'seo_task_distribution_id'
        );
    }

    

}
