<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StageMail extends Mailable
{
    use Queueable, SerializesModels;
     public $subjectText;
    public $messageHtml;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subjectText, $messageHtml)
    {
        $this->subjectText = $subjectText;
        $this->messageHtml = $messageHtml;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Stage Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->html($this->messageHtml); // ✅ Raw HTML
    }
}
