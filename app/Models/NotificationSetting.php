<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_type',
        'user_id',
        'role_id',
        'mail_enabled',
        'system_enabled',
        'sms_enabled',
        'is_active',
    ];

    protected $casts = [
        'mail_enabled'   => 'boolean',
        'system_enabled' => 'boolean',
        'sms_enabled'    => 'boolean',
        'is_active'      => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
