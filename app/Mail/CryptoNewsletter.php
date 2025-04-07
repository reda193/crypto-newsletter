<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

/**
 * Class CryptoNewsletter
 * @package App\Mail
 * 
 * This mailable class is responsible for sending cryptocurrency newsletters
 * to subscribers. It contains subscriber information and cryptocurrency data
 * for display in the email template.
 */
class CryptoNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The subscriber receiving the newsletter.
     *
     * @var Subscriber
     */
    public $subscriber;

    /**
     * Array of cryptocurrency data to be included in the newsletter.
     *
     * @var array
     */
    public $cryptos;

    /**
     * Create a new message instance.
     *
     * @param Subscriber $subscriber The subscriber model
     * @param array $cryptos Array of cryptocurrency data
     */
    public function __construct(Subscriber $subscriber, array $cryptos)
    {
        $this->subscriber = $subscriber;
        $this->cryptos = $cryptos;
    }

    /**
     * Get the message envelope.
     * 
     * Defines the email sender and subject line.
     *
     * @return Envelope
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
     * 
     * Specifies the view to be used for the email content.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.crypto-newsletter',
        );
    }

    /**
     * Get the attachments for the message.
     * 
     * No attachments are included in the cryptocurrency newsletter.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}