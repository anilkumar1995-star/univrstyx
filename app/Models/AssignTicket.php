<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AssignTicket extends Model
{
    protected $table = 'assign_tickets';

    protected $fillable = ['emp_id' ,'user_id', 'ticket_id', 'status', 'subject', 'priority','name', 'file', 'assign_to', 'assign_by', 'department_name'];

    public $with = ['department', 'ticket'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
