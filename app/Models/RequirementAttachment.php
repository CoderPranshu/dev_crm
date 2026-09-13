<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequirementAttachment extends Model
{
    use SoftDeletes;

    const UPDATED_AT = null;

    protected $fillable = [
        'requirement_id',
        'comment_id',
        'uploaded_by',
        'uploaded_by_role',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(RequirementComment::class, 'comment_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
