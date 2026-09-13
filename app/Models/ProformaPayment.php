<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'proforma_id',
        'customer_id',
        'receipt_no',
        'amount',
        'payment_method',
        'transaction_id',
        'payment_date',
        'status',
        'branch_id'
    ];

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }

    public function customer()
    {
        return $this->belongsTo(Company::class, 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
