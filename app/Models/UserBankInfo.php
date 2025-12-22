<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserBankInfo extends Model
{
    protected $table = 'user_basic_infos';

    protected $fillable = ['user_id', 'label','van_number'];

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
