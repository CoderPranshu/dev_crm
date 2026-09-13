<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'priority',
        'rasised_by',
        'subject',
        'department',
        'status',
        'file'
    ];

    public function message()
    {
        return $this->hasMany(SupportTicketMessage::class);
    }

    public function raised()
    {
        return $this->belongsTo(User::class, 'rasised_by');
    }

    public function department()
    {
        return $this->belongsTo(SupportDepartment::class);
    }

}
