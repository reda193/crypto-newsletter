<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class CryptoNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $cryptos;

    /**
     * Create a new message instance.
     */
    public function __construct(Subscriber $subscriber, array $cryptos)
    {
        $this->subscriber = $subscriber;
        $this->cryptos = $cryptos;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                env('MAIL_FROM_ADDRESS', 'postmaster@sandboxf0b3f622148842f6b6395f40f5272192.mailgun.org'),
                env('MAIL_FROM_NAME', 'Crypto Newsletter')
            ),
            subject: 'Your Cryptocurrency Newsletter',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.crypto-newsletter',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}