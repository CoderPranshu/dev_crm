<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BacklinkUpload extends Model
{
    protected $fillable = [
        'backlink_category_id', 'created_by', 'original_name', 'path',
        'extension', 'size', 'headers', 'mapping', 'status',
        'imported', 'skipped', 'invalid',
    ];

    protected $casts = ['headers' => 'array', 'mapping' => 'array'];

    public function category()
    {
        return $this->belongsTo(BacklinkCategory::class, 'backlink_category_id');
    }
}
