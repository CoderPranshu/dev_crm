<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OnPageSeoCategory extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',

        'slug',

        'description',

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

        static::creating(function ($category) {

            if (empty($category->slug)) {

                $category->slug = Str::slug($category->name);

            }

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Tasks
    |--------------------------------------------------------------------------
    */

    public function tasks()
    {
        return $this->hasMany(
            OnPageSeoTask::class,
            'on_page_seo_category_id'
        )->orderBy('sort_order');
    }

    // public function tasks()
    // {
    //     return $this->hasMany(
    //         OnPageSeoTask::class,
    //         'on_page_seo_category_id'
    //     );
    // }
}