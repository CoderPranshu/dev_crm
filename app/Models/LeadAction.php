<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',
        'action_type',
        'action_label',
        'note',
        'quotation_id',
        'meta',
        'action_at',
        'call_count',
    ];

    protected $casts = [
        'meta' => 'array',
        'action_at' => 'datetime',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quotation()
    {
        return $this->belongsTo(
            Quotation::class,
            'quotation_id'
        );
    }
}