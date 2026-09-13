<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grn extends Model
{
    use HasFactory;

    protected $fillable = [
        'grn_no', 'supplier_name', 'grn_date', 'warehouse_id', 'notes', 'branch_id'
    ];

    public function items()
    {
        return $this->hasMany(GrnItem::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function purchaseBill()
    {
        return $this->hasOne(PurchaseBill::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Vendor::class, 'supplier_name');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
