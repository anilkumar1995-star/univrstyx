<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Slider extends Model
{
    protected $table = 'main_slider';

    protected $fillable = ['user_id', 'title', 'subtitle'];


    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
