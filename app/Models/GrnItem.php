<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'grn_id', 'product_id', 'quantity', 'rate', 'amount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
