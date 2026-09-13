<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'roles',
        'designation_id',
        'phone',
        'alter_phone',
        'alternative_phone',
        'status',
        'branch_id',
        'document',
        'dob',
        'join_date',
        'department',
        'manager',
        'employ_type',
        'shift',
        'username',
        'salary',
        'pan_no',
        'aadhar',
        'bank_account_no',
        'ifsc_code',
        'emg_contact_name',
        'emg_contact_number',
        'remark',
        'aadhar_image',
        'pan_image',
        'bank_acc_image',
        'paycode',
        'is_manager'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function recruitment()
    {
        return $this->hasMany(Recuritment::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class, 'assign_to');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function leave()
    {
        return $this->hasMany(Leave_application::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function vendor()
    {
        return $this->hasMany(Vendor::class, 'user_id');
    }

    public function stockuser()
    {
        return $this->hasMany(User::class);
    }

    public function kpi()
    {
        return $this->belongsToMany(Kpi::class);
    }

    public function kras()
    {
        return $this->belongsToMany(Kra::class, 'kra_user')
                    ->withPivot('complete')
                    ->withTimestamps();
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function projectMessages()
    {
        return $this->hasMany(ProjectMessage::class, 'sender_id');
    }

    // User.php
    public function department()
    {
        return $this->belongsTo(Department::class, 'department');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

}
