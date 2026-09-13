<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hsn extends Model
{
    use HasFactory;

    protected $fillable = [
        'hsn_code',
        'description',
        'tax_id',
        'status',
        'branch_id'
    ];

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
