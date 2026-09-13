<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'template_id',
        'status',
        'schedule_time',
        'branch_id'
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'campaign_subscribers', 'campaign_id', 'subscriber_id');
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
