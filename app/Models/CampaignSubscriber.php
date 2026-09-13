<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'campaign_id'
    ];

    public function subscriber()
    {
        return $this->belongsToMany(Subscriber::class);
    }

    // public function campaign()
    // {
    //     return $this->belongsTo(Campaign::class);
    // }
}
