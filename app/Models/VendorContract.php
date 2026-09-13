<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'description',
        'title',
        'doc',
        'contract_number',
        'start_date',
        'end_date',
        'status'
    ];

    public $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
