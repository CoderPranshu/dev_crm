<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttachment extends Model
{
    use HasFactory;

      protected $fillable = [

        'project_id',

        'original_name',

        'file_name',

        'file_path',

        'extension',

        'mime_type',

        'file_size',

        'disk',

        'uploaded_by',

    ];

    /**
     * Project Relationship
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Uploaded By Relationship
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

}
