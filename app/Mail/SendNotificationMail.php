<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $subject, public $message_body, public $attachment_files = [])
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.send_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        if (! empty($this->attachment_files)) {
            foreach ($this->attachment_files as $file) {
                if ($file->isValid()) {
                    $attachment_files[] = $file->getRealPath();
                    $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromPath($file->getRealPath())
                        ->as($file->getClientOriginalName())
                        ->withMime($file->getClientMimeType());
                }
            }
        }

        return $attachments;
    }
}
