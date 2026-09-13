<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'subject', 'body', 'branch_id'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
