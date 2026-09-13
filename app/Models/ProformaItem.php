<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'proforma_id',
        'product_id',
        'price',
        'quantity',
        'line_total',
        'hsn_code',
        'gst',
        'custom_description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
