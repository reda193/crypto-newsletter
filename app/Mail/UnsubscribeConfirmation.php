<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

/**
 * Class UnsubscribeConfirmation
 * @package App\Mail
 * 
 * This mailable class sends a confirmation email to users who have
 * unsubscribed from the cryptocurrency newsletter. It provides them
 * with confirmation that their unsubscription request was processed.
 */
class UnsubscribeConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The name of the user who unsubscribed.
     *
     * @var string
     */
    public $name;

    /**
     * The email address of the user who unsubscribed.
     *
     * @var string
     */
    public $email;

    /**
     * Create a new message instance.
     *
     * @param string $name The name of the user
     * @param string $email The email address of the user
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
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
            subject: 'Unsubscription Confirmation',
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
            view: 'emails.unsubscribe-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     * 
     * No attachments are included in the unsubscription confirmation email.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}