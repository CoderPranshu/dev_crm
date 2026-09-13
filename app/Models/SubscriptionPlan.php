<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type_id',
        'name',
        'price',
        'duration_months',
        'status'
    ];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

}
