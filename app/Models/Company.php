<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'logo',
        'gst_no',
        'contact_person',
        'ship_to',
        'shipping',
        'rating',
        'is_blocked',
        'user_id'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seoPlans()
    {
        return $this->hasMany(SeoPlanClient::class);
    }
}
