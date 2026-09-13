<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bom_id',
        'raw_product_id',
        'quantity',
        'wastage_percent',
        'notes'
    ];

    public function bom()
    {
        return $this->belongsTo(Bom::class, 'bom_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'raw_product_id');
    }
}
