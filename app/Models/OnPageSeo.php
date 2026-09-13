<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnPageSeo extends Model
{
    use HasFactory;

    protected $fillable = [

        'seo_plan_client_id',

        'on_page_seo_task_id',
        'on_page_seo_category_id',   // ye line add karni hai

        'assigned_to',

        'status',

        'remarks',

        'completed_at',

    ];

    /*
    |--------------------------------------------------------------------------
    | SEO Project
    |--------------------------------------------------------------------------
    */

    public function seoPlanClient()
    {
        return $this->belongsTo(
            SeoPlanClient::class,
            'seo_plan_client_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            OnPageSeoCategory::class,
            'on_page_seo_category_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Task
    |--------------------------------------------------------------------------
    */

    public function task()
    {
        return $this->belongsTo(
            OnPageSeoTask::class,
            'on_page_seo_task_id'
        );
    }

 

    public function project()
    {
        return $this->belongsTo(
            SeoPlanClient::class,
            'seo_plan_client_id'
        );
    }
}