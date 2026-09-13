<?php

namespace App\Models;

use App\Models\SeoPlan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status'
    ];

    public function plans()
    {
        return $this->hasMany(SeoPlan::class);
    }


}
