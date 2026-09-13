<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailedQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quotation_type',
        'category_id',
        'service_id',
        'price',
        'content',
        'pdf_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(QuotationCategory::class, 'category_id');
    }

    public function service()
    {
        return $this->belongsTo(QuotationService::class, 'service_id');
    }

}








