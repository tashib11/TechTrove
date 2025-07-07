<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable // Inherits from Mailable, so Laravel can send it via Mail::to()->send(...)
{
    // Queueable, Makes the email send in background without blocking user interface
    //SerializesModels, if your mail gets user model or product, Laravel handles them smartly in queue
    use Queueable, SerializesModels;
    public $details;//Laravel automatically shares public properties of Mailable class with the Blade view when rendering.


    /**
     * Create a new message instance.
     */
    public function __construct($details)//__construct is the magic method in PHP for constructor
    {
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope//  setting the email subject here
    {
        return new Envelope(
            subject: 'TechTrove OTP Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content //Blade view should be rendered for email body
    {
        return new Content(
            view: 'email.OTPMail',
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
