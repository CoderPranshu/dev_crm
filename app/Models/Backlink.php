<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backlink extends Model
{
    use HasFactory;

    protected $fillable = [

        'backlink_category_id',

        'website_url',

        'domain_authority',

        'page_authority',

        'username',

        'password',

        'status',

        'assigned_to',

        'assigned_by',

        'assigned_at',

        'completed_at',

        'created_by',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            BacklinkCategory::class,
            'backlink_category_id'
        );
    }

    public function assignedTo()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function assignedBy()
    {
        return $this->belongsTo(
            User::class,
            'assigned_by'
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function assignments()
    {
        return $this->hasMany(
            BacklinkAssignment::class,
            'backlink_id'
        );
    }
}
