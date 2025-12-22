<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UpiCollect extends Model
{
    protected $table = 'fund_recieved_callback';

    protected $fillable = ['id','fund_id','event','remitter_full_name'];

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
