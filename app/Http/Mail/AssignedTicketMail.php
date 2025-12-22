<?php
namespace App\Http\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class AssignedTicketMail extends Mailable
{
    use Queueable, SerializesModels;
    public $ticket;
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }
    public function build()
    {
        $ticket = $this->ticket;
        return $this->subject('Your Support Ticket Has Been Assigned')
                    ->view('emails.ticket_assigned', compact('ticket'));
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Assigned Mail',
        );
    }
}