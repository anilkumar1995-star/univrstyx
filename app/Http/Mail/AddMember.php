<?php
namespace App\Http\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class AddMember extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }
    public function build()
    {
        return $this->subject('Add Member')
                    ->view('emails.addmember');
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Add Member',
        );
    }
}