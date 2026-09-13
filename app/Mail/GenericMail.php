<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class GenericMail extends Mailable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject($this->data['subject'] ?? 'Notification')
                    ->view('emails.generic')
                    ->with('data', $this->data);
    }
}
