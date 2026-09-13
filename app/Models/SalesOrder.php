<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'so_no',
        'proforma_id',
        'customer_id',
        'subtotal',
        'tax',
        'total',
        'status',
        'expected_delivery_date',
        'internal_notes',
        'production_status',
        'manufactured',
        'branch_id'
    ];

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }

    public function customer()
    {
        return $this->belongsTo(Company::class);
    }

    public function productionConsumptions()
    {
        return $this->hasMany(ProductionConsumption::class, 'sales_order_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
