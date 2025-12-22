<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FooterMedia extends Model
{
    protected $table = 'footer_media';

    protected $fillable = ['user_id', 'media_heading', 'status'];


    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
