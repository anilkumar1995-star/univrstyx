<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Header extends Model
{
    protected $table = 'header_content';

    protected $fillable = ['user_id', 'header_1', 'header_2','header_3'];


    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
