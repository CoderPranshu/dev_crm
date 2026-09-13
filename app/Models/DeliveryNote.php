<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_no',
        'sales_order_id',
        'customer_id',
        'dispatch_date',
        'tracking_no',
        'courier_name',
        'status',
        'docket_no',
        'company_link',
        'branch_id'
    ];

    public function items()
    {
        return $this->hasMany(DeliveryNoteItem::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(Invoice::class, 'sales_order_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
