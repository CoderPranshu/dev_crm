<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'version',
        'notes',
        'is_active',
        'branch_id',
        'bom_no'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(BomItem::class, 'bom_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
