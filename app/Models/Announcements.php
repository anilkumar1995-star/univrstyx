<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Announcements extends Model
{
    protected $table = 'announcements';

    protected $fillable = ['user_id', 'header_1', 'heading_2','btn_text','description', 'footer_content', 'status'];


    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
