<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiometricPunch extends Model
{
    protected $table = 'biometric_punches';

    protected $fillable = [
        'employee_no',
        'punch_at'
    ];

    public $timestamps = true;
}