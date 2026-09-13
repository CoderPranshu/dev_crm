<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'lead_id',
        'user_id',
        'create_date',
        'due_date',
        'note',
        'terms_condition',
        'discount',
        'payment_type',
        'payment_currency',
        'vat',
        'sales_credit',
        'quotation_type',
    ];

    protected $casts = [
        'create_date' => 'date',
        'due_date' => 'date',
    ];


    public function client()
    {
        return $this->belongsTo(
            Company::class,
            'client_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | QUICK QUOTATION LEAD
    |--------------------------------------------------------------------------
    */

    public function lead()
    {
        return $this->belongsTo(
            Lead::class,
            'lead_id'
        );
    }


    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    public function items()
    {
        return $this->hasMany(
            QuotationItem::class,
            'quotation_id'
        );
    }


    public function salesCredit()
    {
        return $this->belongsTo(
            User::class,
            'sales_credit'
        );
    }
}