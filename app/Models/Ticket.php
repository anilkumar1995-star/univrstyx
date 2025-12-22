<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = ['ticket_id' ,'name', 'email','plateform', 'status', 'subject', 'priority','assign_by', 'assign_to', 'description', 'department_name', 'file'];

    // public $with = ['department'];

    // public function department()
    // {
    //     return $this->belongsTo(Department::class, 'department_id', 'id');
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
