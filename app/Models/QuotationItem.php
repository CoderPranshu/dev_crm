<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'quantity',
        'description',
        'custom_description',
        'unit_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'description');
    }
}
