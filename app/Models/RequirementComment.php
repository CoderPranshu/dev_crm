<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequirementComment extends Model
{
    use SoftDeletes;

    protected $fillable = ['requirement_id', 'user_id', 'parent_id', 'comment'];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(RequirementComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(RequirementComment::class, 'parent_id')->oldest();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(RequirementAttachment::class, 'comment_id');
    }
}
