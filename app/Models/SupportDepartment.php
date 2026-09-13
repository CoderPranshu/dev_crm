<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch_id',
        'description'
    ];

    public function support()
    {
        return $this->hasMany(Support::class);
    }
}
