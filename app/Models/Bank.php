<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Bank extends Model
{
    protected $table = 'user_banks';

    protected $fillable = ['user_id', 'name','type', 'bank_name','account_number', 'ifsc_code','verify_bank', 'status','is_verify'];
  
    public $with = ['department', 'ticket','van'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }
       
    public function van()
    {
        return $this->belongsTo(UserBankInfo::class, 'bank_id', 'id');
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
