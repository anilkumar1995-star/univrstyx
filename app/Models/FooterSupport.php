<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FooterSupport extends Model
{
    protected $table = 'footer_support';

    protected $fillable = ['user_id', 'support_heading', 'status'];


    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
