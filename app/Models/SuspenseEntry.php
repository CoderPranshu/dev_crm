<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspenseEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry_date',
        'type',
        'amount',
        'reference_no',
        'description',
    ];
}
