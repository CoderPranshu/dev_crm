<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_category_id',
        'name',
        'status',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(
            SubscriptionCategory::class,
            'subscription_category_id'
        );
    }

}
