<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomCandidateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageBody;
    public $candidateName;

    public function __construct($subjectText, $messageBody, $candidateName)
    {
        $this->subjectText = $subjectText;
        $this->messageBody = $messageBody;
        $this->candidateName = $candidateName;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->markdown('emails.candidate')
                    ->with([
                        'messageBody' => $this->messageBody,
                        'candidateName' => $this->candidateName,
                    ]);
    }
}
