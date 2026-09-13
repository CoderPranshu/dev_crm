<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorQuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_quotation_id',
        'product_id',
        'quantity',
        'price',
        'delivery_days'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
