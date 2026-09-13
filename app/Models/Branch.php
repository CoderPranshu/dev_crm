<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'description', 'machine_serial', 'address', 'gstin', 'state', 'state_code', 'logo', 'company_name', 'terms_condition', 'contact_person', 'phone_no'  
    ];

    public function department()
    {
        return $this->hasMany(Department::Class);
    }

    public function recruitment()
    {
        return $this->hasMany(Recruitment::class);
    }

    public function kra()
    {
        return $this->hasMany(Kra::class);
    }

    // public function product()
    // {
    //     return $this->hasMany(Product::class, 'branch_id');
    // }
}
