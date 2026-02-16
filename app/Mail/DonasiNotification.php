<?php

namespace App\Mail;

use App\Models\Donasi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonasiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Donasi $donasi;

    public function __construct(Donasi $donasi)
    {
        $this->donasi = $donasi;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima Kasih Atas Donasi Anda - Panti Asuhan Bumi Damai',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.donasi-notification',
            with: [
                'donasi' => $this->donasi,
                'program' => $this->donasi->program,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
