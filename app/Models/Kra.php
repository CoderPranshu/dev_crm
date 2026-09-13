<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kra extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'department_id',
        'branch_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function Task()
    {
        return $this->hasMany(Task::class, 'kra');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'kra_user')
                    ->withPivot('complete')   // 👈 REQUIRED
                    ->withTimestamps();
    }

}
