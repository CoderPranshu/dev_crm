<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectSubModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_module_id',
        'sub_module_name',
        'description',
        'assigned_to',
        'priority',
        'status',
        'progress',
        'estimated_hours',
        'actual_hours',
        'start_date',
        'deadline',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
        // Review system
        'last_reviewed_at',
        'last_reviewed_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'progress' => 'integer',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'start_date' => 'date',
        'deadline' => 'date',
        'last_reviewed_at' => 'datetime',
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

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Full, append-only review history for this sub module — oldest first
     * by default (use ->latest() at the call site for newest-first).
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(SubmoduleReview::class, 'project_sub_module_id')
            ->orderBy('review_round');
    }

    public function lastReviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_reviewed_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWaitingReview($query)
    {
        return $query->where('status', 'Ready For Review');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    public function scopeChangesRequested($query)
    {
        return $query->where('status', 'Changes Requested');
    }

    /*
    |--------------------------------------------------------------------------
    | Review-state helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Once Approved, a sub module is hard-locked: no status change, edit,
     * attachment/remark modification, or delete is allowed until a Lead
     * Developer or Admin explicitly reopens it (future feature).
     */
    public function isLocked(): bool
    {
        return $this->status === 'Approved';
    }

    public function isWaitingReview(): bool
    {
        return $this->status === 'Ready For Review';
    }

    public function needsChanges(): bool
    {
        return $this->status === 'Changes Requested';
    }

    public function nextReviewRound(): int
    {
        return (int) $this->reviews()->max('review_round') + 1;
    }
}
