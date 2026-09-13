<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'leads_id',
        'description',
        'title',
        'slug',
        'person',
        'stage',
        'close_date',
        'call_again',
        'remarks',
        'requirement',
        'assign_to',
        'company_id',
        'stage_change_date',
    ];

    public function leads()
    {
        return $this->belongsTo(Lead::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function userAssign()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

}
