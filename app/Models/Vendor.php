<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'company',
        'website',
        'notes',
        'status',
        'vendor_type',
        'conact_person',
        'tax_id',
    ];


    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchaseOrder()
    {
        return $this->hasMany(PurchaseOrder::class, 'vendor_id');
    }

    public function vendorRate()
    {
        return $this->hasMany(VendorRate::class, 'vendor_id');
    }
}
