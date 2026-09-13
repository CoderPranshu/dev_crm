<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ProjectMessageFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_message_id',
        'original_name',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function message()
    {
        return $this->belongsTo(ProjectMessage::class);
    }
}
