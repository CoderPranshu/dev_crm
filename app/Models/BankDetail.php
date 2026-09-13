<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ac_holder_name',
        'bank_name',
        'ac_no',
        'branch_name',
        'ifsc_code',
        'branch_id'
    ];
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
