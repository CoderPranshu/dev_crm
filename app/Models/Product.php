<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','sku','category_id','unit','cost_price','sale_price','opening_stock','min_stock','is_stock_item','meta', 'stock', 'waste_stock', 'branch_id'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockmove()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function bom()
    {
        return $this->hasMany(Bom::class);
    }

    public function purchaseReq()
    {
        return $this->hasMany(PurchaseRequisition::class, 'product_id');
    }

    public function advanceServices()
    {
        return $this->belongsToMany(AdvanceService::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
