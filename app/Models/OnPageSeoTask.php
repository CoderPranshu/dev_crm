<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OnPageSeoTask extends Model
{
    use HasFactory;

    protected $fillable = [

        'on_page_seo_category_id',

        'task_name',

        'slug',

        'input_type',

        'placeholder',

        'options',

        'is_required',

        'sort_order',

        'status',

    ];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {

            if (empty($task->slug)) {

                $task->slug = Str::slug($task->task_name);

            }

        });

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

    public function projectTask()
    {
        return $this->hasOne(
            OnPageSeo::class,
            'on_page_seo_task_id'
        );
    }

}