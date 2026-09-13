<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];
    

    public function serviceTypes()
    {
        return $this->hasMany(ServiceType::class, 'subscription_category_id');
    }
}
