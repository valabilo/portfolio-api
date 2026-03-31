<?php
// portfolio-api/app/Mail/ContactReceived.php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * The Contact model is injected — its data fills the email template.
     */
    public function __construct(
        public readonly Contact $contact
    ) {}

    /**
     * Subject line shown in Val's inbox.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[ValOS Portfolio] New message from {$this->contact->name}",
            replyTo: [
                new \Illuminate\Mail\Mailables\Address(
                    $this->contact->email,
                    $this->contact->name
                ),
            ],
        );
    }

    /**
     * HTML + plain-text views for the email.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.contact-received',
            text: 'emails.contact-received-text',
        );
    }

    /**
     * No attachments.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
