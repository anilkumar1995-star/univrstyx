<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ReplyTicket extends Model
{
    protected $table = 'reply_tickets';

    protected $fillable = ['emp_id', 'ticket_id', 'status', 'assign_to','file', 'desc','partner_id', 'user_id'];

       public $with = ['ticket'];
      public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'emp_id', 'agentcode');
}
    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
