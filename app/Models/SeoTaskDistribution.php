<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoTaskDistribution extends Model
{
    use HasFactory;

      protected $fillable = [
        'seo_plan_client_id',
        'seo_plan_task_id',
        'user_id',
        'day',
        'status',
    ];

    // 1. Task Relation (Jis task ka distribution hua hai)
    // public function task()
    // {
    //     return $this->belongsTo(SeoPlanTask::class, 'seo_plan_task_id');
    // }

    // 2. Client Relation
    public function client()
    {
        return $this->belongsTo(SeoPlanClient::class, 'seo_plan_client_id');
    }

    // 3. Executive / User Relation (Jisko assign hua hai)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 

   

   
    public function work()
    {
        return $this->hasOne(
            SeoTeamWork::class,
            'seo_task_distribution_id'
        );
    }

    public function task()
    {
        return $this->belongsTo(
            SeoPlanTask::class,
            'seo_plan_task_id'
        );
    }
}
