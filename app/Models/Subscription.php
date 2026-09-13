<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'company_name',
        'email',
        'mobile',
        'purchase_date',
        'duration_months',
        'expiry_date',
        'total_amount',
        'renew_before_days',
        'status',
        'remarks',
        'company_id',
    ];

    public function items()
    {
        return $this->hasMany(
            SubscriptionItem::class
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
        return $this->belongsTo(ServiceType::class);
    }

    public function plan()
    {
        return $this->belongsTo(
            SubscriptionPlan::class,
            'subscription_plan_id'
        );
    }

    public function renewals()
    {
        return $this->hasMany(Renewal::class);
    }

    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function getPaidAmountAttribute()
    {
        return $this->payments()
            ->sum('amount');
    }
    
    public function getDueAmountAttribute()
    {
        return $this->total_amount
            - $this->paid_amount;
    }

    public function company()
    {
        return $this->belongsTo(
            Company::class
        );
    }
}
