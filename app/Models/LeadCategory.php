<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadCategory extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'api'];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'categories_id');
    }
}
