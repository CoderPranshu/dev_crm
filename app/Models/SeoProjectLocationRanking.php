<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoProjectLocationRanking extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_project_location_id',
        'month_no',
        'ranking',
    ];

    protected $casts = [
        'month_no' => 'integer',
        'ranking' => 'integer',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(SeoProjectLocation::class, 'seo_project_location_id');
    }
}