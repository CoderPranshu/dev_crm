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
        'file',
        'ticket_no',
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
        return $this->belongsTo(SupportDepartment::class, 'department');
    }

    protected static function booted(): void
    {
        static::creating(function ($ticket) {
            if (empty($ticket->ticket_no)) {
                do {
                    $ticketNumber = (string) random_int(100000, 999999);
                } while (
                    self::where('ticket_no', $ticketNumber)->exists()
                );

                $ticket->ticket_no = $ticketNumber;
            }
        });
    }


}
