<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file',
        'vendor_id',
        'description',
        'warranty_no',
        'status',
        'product_id',
        'assign_to',
        'service_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function assignedVendor()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function histories()
    {
        return $this->hasMany(WarrantyHistory::class, 'warranty_claim_id')->latest('date');
    }

}
