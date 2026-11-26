<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientBacklinkImport extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'seo_plan_client_id',
        'backlink_category_id',
        'uploaded_by',
        'original_name',
        'path',
        'extension',
        'size',
        'headers',
        'mapping',
        'total_rows',
        'imported',
        'skipped',
        'invalid',
        'status',
        'error_message',
        'processed_at',
    ];

    protected $casts = [
        'headers' => 'array',
        'mapping' => 'array',
        'size' => 'integer',
        'total_rows' => 'integer',
        'imported' => 'integer',
        'skipped' => 'integer',
        'invalid' => 'integer',
        'processed_at' => 'datetime',
    ];

    /**
     * SEO client/project that owns this import.
     */
    public function seoPlanClient(): BelongsTo
    {
        return $this->belongsTo(
            SeoPlanClient::class,
            'seo_plan_client_id'
        );
    }

    /**
     * Category selected while uploading the file.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            BacklinkCategory::class,
            'backlink_category_id'
        );
    }

    /**
     * User who uploaded the source file.
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'uploaded_by'
        );
    }

    /**
     * Client backlink assignments created from this import.
     */
    public function backlinkAssignments(): HasMany
    {
        return $this->hasMany(
            BacklinkAssignment::class,
            'client_backlink_import_id'
        );
    }
}