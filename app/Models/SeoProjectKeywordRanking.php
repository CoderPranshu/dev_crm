<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoProjectKeywordRanking extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_project_keyword_id',
        'month_no',
        'ranking',
    ];

    protected $casts = [
        'month_no' => 'integer',
        'ranking' => 'integer',
    ];

    public function keyword(): BelongsTo
    {
        return $this->belongsTo(SeoProjectKeyword::class, 'seo_project_keyword_id');
    }
}