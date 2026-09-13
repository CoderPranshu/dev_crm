<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_service_id',
        'name',
        'duration',
        'description',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(SeoService::class,'seo_service_id');
    }

    public function taskTemplates()
    {
        return $this->hasMany(SeoTaskTemplate::class);
    }

    public function tasks()
    {
        return $this->hasMany(SeoPlanTask::class);
    }

    public function clients()
    {
        return $this->hasMany(SeoPlanClient::class);
    }
}
