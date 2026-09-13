<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationService extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'default_price',
    ];

    public function category()
    {
        return $this->belongsTo(
            QuotationCategory::class,
            'category_id'
        );
    }
}

