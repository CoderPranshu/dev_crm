<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnBoarding extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'email_template',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'onboarding', 'id')->where('cand_type', 'awaiting');
    }
}
