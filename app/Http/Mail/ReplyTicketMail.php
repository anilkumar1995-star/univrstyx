<?php
namespace App\Http\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class ReplyTicketMail extends Mailable
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
        return $this->subject('Your Support Ticket Has Been Replied')
                    ->view('emails.reply_ticket',compact('ticket'));
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket reply Mail',
        );
    }
}