<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorReturnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_return_id',
        'product_id',
        'qty',
        'condition'
    ];

    public function vendorReturn()
    {
        return $this->belongsTo(VendorReturnItem::class, 'vendor_return_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
