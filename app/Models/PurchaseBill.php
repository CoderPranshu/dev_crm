<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'grn_id',
        'bill_no',
        'bill_date',
        'supplier_name',
        'taxable_amount',
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'total_tax',
        'total_amount',
        'paid_amount',
        'due_amount',
        'status',
        'branch_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Vendor::class, 'supplier_name');
    }

    public function items()
    {
        return $this->hasMany(PurchaseBillItem::class);
    }

    public function grn()
    {
        return $this->belongsTo(Grn::class);
    }

    public function payments()
    {
        return $this->hasMany(VendorPayment::class, 'purchase_bill_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
