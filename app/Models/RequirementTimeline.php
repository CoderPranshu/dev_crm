<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequirementTimeline extends Model
{
    const UPDATED_AT = null; // immutable log, created_at only

    protected $fillable = [
        'requirement_id',
        'event_type',
        'actor_id',
        'from_status',
        'to_status',
        'meta',
        'description',
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
