<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionConsumption extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_order_id',
        'raw_product_id',
        'quantity_used',
        'sales_order_id',
        'warehouse_id',
        'production_consumption_no',
        'branch_id'
    ];

    public function procutionCom()
    {
        return $this->belongsTo(Product::class, 'raw_product_id');
    }

    public function productOrder()
    {
        return $this->belongsTo(ProductionOrder::class, 'production_order_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
