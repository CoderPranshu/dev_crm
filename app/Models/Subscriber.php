<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'status'
    ];

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_subscribers', 'subscriber_id', 'campaign_id');
    }
}
