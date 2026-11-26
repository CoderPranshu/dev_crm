<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'subscription_category_id',
        'service_type_id',
        'price',
        'domain_name'
    ];

    public function subscription()
    {
        return $this->belongsTo(
            Subscription::class
        );
    }

    public function category()
    {
        return $this->belongsTo(
            SubscriptionCategory::class,
            'subscription_category_id'
        );
    }

    public function serviceType()
    {
        return $this->belongsTo(
            ServiceType::class
        );
    }
}
