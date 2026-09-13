<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',

        'product_id',
        'price',
        'line_total',
        'hsn_code',
        'tax_id',
        'tax_rate'
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Hsn()
    {
        return $this->belongsTo(Hsn::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
