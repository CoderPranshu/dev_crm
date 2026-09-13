<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'warranty_claim_id',
        'action',
        'old_status',
        'new_status',
        'note',
        'changed_by',
        'assigned_to',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function claim()
    {
        return $this->belongsTo(WarrantyClaim::class, 'warranty_claim_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
