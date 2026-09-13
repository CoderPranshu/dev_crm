<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    use HasFactory;

    protected $fillable = ['pr_id', 'rfq_number', 'last_date', 'status', 'branch_id'];

    public function items()
    {
        return $this->hasMany(RfqItem::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'rfq_vendor')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
