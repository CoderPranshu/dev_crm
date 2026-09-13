<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'recruitment_id'
    ];

    public function recruitments()
    {
        return $this->belongsTo(Recruitment::class);
    }

    public function candi()
    {
        return $this->hasMany(Candidate::class)->whereNull('is_final');
    }
}
