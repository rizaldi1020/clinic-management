<?php

namespace App\Mail;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BillPaid extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Bill $bill) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🧾 Bukti Pembayaran — {$this->bill->invoice_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tagihan.paid',
        );
    }
}
