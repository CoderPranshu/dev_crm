<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_module_id',
        'requirement_type_id',
        'raised_by',
        'title',
        'description',
        'status',
        'priority',
        'is_blocker',
        'forwarded_to',
        'seen_by',
        'seen_at',
        'completed_at',
        'completed_by',
        'rejected_at',
        'rejection_reason',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_blocker' => 'boolean',
        'seen_at' => 'datetime',
        'completed_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function module(): BelongsTo
    {
        return $this->belongsTo(ProjectModule::class, 'project_module_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(RequirementType::class, 'requirement_type_id');
    }

    public function raisedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'raised_by');
    }

    public function seenByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seen_by');
    }

    public function completedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function timeline(): HasMany
    {
        return $this->hasMany(RequirementTimeline::class)->orderBy('created_at');
    }

    /**
     * Top-level comments only. Replies are loaded via ->replies on each.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(RequirementComment::class)->whereNull('parent_id')->latest();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(RequirementAttachment::class)->whereNull('comment_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeBlocking($query)
    {
        return $query->where('is_blocker', true)
            ->whereNotIn('status', ['Completed', 'Rejected']);
    }

    public function scopeOpen($query)
    {
        return $query->whereNotIn('status', ['Completed', 'Rejected']);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isSeen(): bool
    {
        return $this->seen_at !== null;
    }
}
