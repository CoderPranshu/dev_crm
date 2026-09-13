<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_note_id',
        'product_id',
        'quantity',
        'hsn_code',
        'gst',
        'unit_price',
        'line_total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
