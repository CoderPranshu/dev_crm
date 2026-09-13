<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'type',
        'status',
        'branch_id'
    ];


    public function vendor()
    {
        return $this->hasMany(Vendor::class);
    }

    public function hsn()
    {
        return $this->hasMany(Has::class);
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
