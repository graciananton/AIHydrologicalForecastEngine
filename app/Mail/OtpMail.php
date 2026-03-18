<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;
    private string $opt;
    /**
     * Create a new message instance.
     */
    public function __construct(string $opt)
    {
        $this->opt = $opt;
        // internally calls envelope(), content(), attachments() even though not called in __construct()
    }

    /**
     * Get the message envelope.
     * email headers (subject, from, reply-to)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Code',
        );
    }

    /**
     * Get the message content definition.
     * renders email content using otp blade file
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'opt'=> $this->opt
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    
}
