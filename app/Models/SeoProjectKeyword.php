<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoProjectKeyword extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_plan_client_id',
        'keyword',
        'search_volume',
        'starting_rank',
    ];

    protected $casts = [
        'search_volume' => 'integer',
        'starting_rank' => 'integer',
    ];

    public function seoPlanClient(): BelongsTo
    {
        return $this->belongsTo(SeoPlanClient::class, 'seo_plan_client_id');
    }

    public function rankings(): HasMany
    {
        return $this->hasMany(SeoProjectKeywordRanking::class, 'seo_project_keyword_id');
    }
}