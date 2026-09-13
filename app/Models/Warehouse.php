<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'address'
    ];

    public function stock()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function productionCom()
    {
        return $this->hasMany(ProductionConsumption::class, 'warehouse_id');
    }

    public function grn()
    {
        return $this->hasMany(Grn::class);
    }
}
