<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoTeamTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_plan_client_id',
        'team_name',
        'notes',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(SeoPlanClient::class,'seo_plan_client_id');
    }

    public function seoPlanClient()
    {
        return $this->belongsTo(SeoPlanClient::class);
    }

    public function items()
    {
        return $this->hasMany(SeoTeamTaskItem::class);
    }
    
}
