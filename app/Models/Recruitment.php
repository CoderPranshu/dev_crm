<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'manager_id', 'description', 'start_date', 'end_date', 'department_id', 'branch_id', 'position'
    ];

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function candidate()
    {
        return $this->hasMany(Candidate::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'position');
    }

}
