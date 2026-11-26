<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoProjectStateGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_plan_client_id',
        'name',
    ];

    public function seoPlanClient(): BelongsTo
    {
        return $this->belongsTo(
            SeoPlanClient::class,
            'seo_plan_client_id'
        );
    }

    public function states(): HasMany
    {
        return $this->hasMany(
            SeoProjectLocation::class,
            'state_group_id'
        )->where('type', SeoProjectLocation::TYPE_STATE);
    }
}