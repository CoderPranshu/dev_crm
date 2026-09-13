<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'source', 'country', 'state', 'resume', 'dob', 'stage_id', 'recruitment_id', 'document', 'onboarding', 'is_emp', 'job_name'
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class);
    }

    public function onboarding()
    {
        return $this->belongsTo(OnBoarding::class, 'onboarding', 'id');
    }

}
