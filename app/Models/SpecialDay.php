<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'occasion_date',
        'category',
        'icon',
        'is_major',
        'is_active',
    ];

    protected $casts = [
        'occasion_date' => 'date',
        'is_major' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeToday(Builder $query): Builder
    {
        $today = now('Asia/Kolkata')->toDateString();

        return $query->whereDate('occasion_date', $today);
    }

    public function scopeUpcoming(
        Builder $query,
        int $days = 7
    ): Builder {
        $today = now('Asia/Kolkata')->startOfDay();
        $lastDate = $today->copy()->addDays($days);

        return $query
            ->whereDate('occasion_date', '>', $today->toDateString())
            ->whereDate('occasion_date', '<=', $lastDate->toDateString())
            ->orderBy('occasion_date');
    }
}


