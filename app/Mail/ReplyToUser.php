<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyToUser extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;
    public $originalMessage;
    public $reply;
    public function __construct(Message $originalMessage, Message $reply)
    {
        $this->originalMessage = $originalMessage;
        $this->reply = $reply;
    }
    public function build()
    {
        return $this->subject('Balasan dari Admin')
                    ->view('emails.reply-to-user')  // Buat view ini di resources/views/emails/
                    ->with(['original' => $this->originalMessage, 'reply' => $this->reply]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reply To User',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
