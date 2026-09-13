<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequisitionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_id',
        'product_id',
        'required_qty',
        'available_qty',
        'to_order_qty',
        'priority',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
