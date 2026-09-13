<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'requisition_id', 'total_amount', 'po_number','order_date',
        'status', 'rfq_id',
        'vendor_quotation_id',
        'branch_id'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function purchaseRequisition()
    {
        return $this->belongsTo(PurchaseRequisition::class, 'requisition_id');
    }

        public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'po_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
