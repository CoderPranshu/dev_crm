<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_id',
        'product_id',
        'order_qty',
        'amount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
