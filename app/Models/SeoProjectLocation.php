<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoProjectLocation extends Model
{
    use HasFactory;

    public const TYPE_AREA = 'area';
    public const TYPE_STATE = 'state';

    protected $fillable = [
        'seo_plan_client_id',
        'type',
        'name',
    ];

    public function seoPlanClient(): BelongsTo
    {
        return $this->belongsTo(SeoPlanClient::class, 'seo_plan_client_id');
    }

    public function rankings(): HasMany
    {
        return $this->hasMany(SeoProjectLocationRanking::class, 'seo_project_location_id');
    }

    public function scopeAreas($query)
    {
        return $query->where('type', self::TYPE_AREA);
    }

    public function scopeStates($query)
    {
        return $query->where('type', self::TYPE_STATE);
    }
}