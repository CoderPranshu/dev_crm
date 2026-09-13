<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'old_expiry_date',
        'new_expiry_date',
        'duration_months',
        'amount',
        'renewal_date',
        'remarks'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

}