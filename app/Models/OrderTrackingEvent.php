<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTrackingEvent extends Model
{
    use HasFactory;

     protected $fillable = [
        'sales_order_id',
        'status',
        'title',
        'description',
        'event_time'
    ];

    public function order()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }
}
