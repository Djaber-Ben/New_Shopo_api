<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $url = url('/reset-password-form?token=' . $this->token . '&email=' . urlencode($this->email));

        return $this->subject('Reset Your Password')
                    ->markdown('emails.reset-password')
                    ->with([
                        'url' => $url,
                        'email' => $this->email,
                    ]);
    }
}
