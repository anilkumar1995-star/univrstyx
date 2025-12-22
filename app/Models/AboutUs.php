<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AboutUs extends Model
{
    protected $table = 'about_us';

    protected $fillable = ['user_id', 'heading', 'description', 'button_text', 'status'];


    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
