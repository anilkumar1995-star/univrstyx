<?php
namespace App\Http\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class TicketSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $ticket;
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }
    public function build()
    {
        return $this->subject('Your Support Ticket Has Been Submitted')
                    ->view('emails.ticket_submitted');
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Submitted Mail',
        );
    }
}