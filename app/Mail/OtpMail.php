<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Log;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;
    private string $otp;
    /**
     * Create a new message instance.
     */
    public function __construct(string $otp)
    {
        Log::channel("laravel")->info("OtpMail class initialization");
        $this->otp = $otp;
        // internally calls envelope(), content(), attachments() even though not called in __construct()
    }

    /**
     * Get the message envelope.
     * email headers (subject, from, reply-to)
     */
    public function envelope(): Envelope
    {
        Log::channel("laravel")->info("Creating envelope header details");
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
        Log::channel("laravel")->info("Creating content details");
        return new Content(
            view: 'emails.otp',
            with: [
                'otp'=> $this->otp
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
        Log::channel("laravel")->info("Creating attachments details");
        return [];
    }
    
}
