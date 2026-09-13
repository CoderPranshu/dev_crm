<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseBillItem extends Model
{
    use HasFactory;

     protected $fillable = [
        'purchase_bill_id',
        'product_id',
        'quantity',
        'rate',
        'amount',
        'hsn_code',
        'gst_rate',
        'gst_amount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
