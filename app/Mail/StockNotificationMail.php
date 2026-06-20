<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class StockNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stocks;

    /**
     * Create a new message instance.
     */
    public function __construct($stocks)
    {
        $this->stocks = $stocks;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Stock 3 Hari Lalu',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.stock_notification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView(
            'pdf.stock_download',
            ['stocks' => $this->stocks]
        )->setPaper('a4', 'landscape'); 

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                'Laporan_Stock_3_Hari_Lalu.pdf'
            )->withMime('application/pdf'),
        ];
    }
}