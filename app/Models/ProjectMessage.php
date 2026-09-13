<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ProjectMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'sender_id',
        'sender_type',
        'message',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function files()
    {
        return $this->hasMany(ProjectMessageFile::class);
    }
}
