<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'bom_id',
        'finished_product_id',
        'quantity',
        'status',
        'meta',
        'production_status',
        'branch_id',
        'production_no'
    ];

    public function finishedProduct()
    {
        return $this->belongsTo(Product::class, 'finished_product_id');
    }

    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
