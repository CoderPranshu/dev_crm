<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lead;


class Proforma extends Model
{
    use HasFactory;

    protected $fillable = [
        'proforma_no',
        'customer_id',
        'proforma_date',
        'subtotal',
        'tax',
        'total',
        'status',
        'notes',
        'branch_id',
        'lead_id',
        'stage',
    ];

    public function items()
    {
        return $this->hasMany(ProformaItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Company::class);
    }

    public function payment()
    {
        return $this->hasMany(ProformaPayment::class);
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function lead()
{
    return $this->belongsTo(
        Lead::class,
        'lead_id'
    );
}
}
