<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortList extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'source',
        'country',
        'state',
        'resume',
        'dob',
        'stage_id',
        'recruitment_id',
        'document',
        'candidate_id',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class, 'recruitment_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
