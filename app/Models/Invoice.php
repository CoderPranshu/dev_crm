<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'create_date',
        'due_date',
        'note',
        'terms_condition',
        'discount',
        'payment_type',
        'payment_currency',
        'payment_status',
        'send_interval',
        'send_date',
        'email_subject',
        'email_body',
        'attach',
        'schedule',
        'recurring',
        'sent',
        'is_scheduled',
        'vat',

        'invoice_no',
        'sales_order_id',
        'customer_id',
        'invoice_date',
        'subtotal',
        'tax',
        'total',
        'status',

        'decleration',
        'terms',
        'acc_details',
        'o_status',
        'branch_id'
    ];

    protected $casts = [
        'send_date' => 'date',
        'create_date' => 'date',
        'due_date' => 'date',
        'is_schedule_sent' => 'boolean',
        'attach' => 'boolean',
        'is_scheduled' => 'boolean',
    ];


    public function customer()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function account()
    {
        return $this->belongsTo(BankDetail::class, 'acc_details');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
