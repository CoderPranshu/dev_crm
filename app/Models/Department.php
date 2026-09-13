<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'branch'
    ];

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch');
    }

    public function designation()
    {
        return $this->hasMany(Designation::class, 'department_id');
    }

    public function recruitment()
    {
        return $this->hasMany(Recruitment::class);
    }

    public function kra()
    {
        return $this->hasMany(Kra::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}








