<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A single review decision made against a ProjectSubModule.
 *
 * Rows here are NEVER updated or deleted by application code — this is
 * an append-only audit trail. To "undo" a review, a new row is created
 * (e.g. via a future reopen() action), never an edit of an old one.
 */
class SubmoduleReview extends Model
{
    use HasFactory;

    protected $table = 'submodule_reviews';

    protected $fillable = [
        'project_sub_module_id',
        'reviewed_by',
        'decision',
        'remarks',
        'review_round',
    ];

    protected $casts = [
        'project_sub_module_id' => 'integer',
        'reviewed_by' => 'integer',
        'review_round' => 'integer',
    ];

    public function subModule(): BelongsTo
    {
        return $this->belongsTo(ProjectSubModule::class, 'project_sub_module_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('decision', 'Approved');
    }

    public function scopeChangesRequested($query)
    {
        return $query->where('decision', 'Changes Requested');
    }
}
