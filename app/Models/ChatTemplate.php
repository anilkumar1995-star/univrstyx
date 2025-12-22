<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ChatTemplate extends Model
{
    protected $table = 'chat_template';

    protected $fillable = [
        'user_id',
        'integrated_number',
        'template_type',
        'template_id',
        'template_name',
        'call_btn_txt',
        'call_btn_num',
        'header_var',
        'body_var',
        'language',
        'category',
        'button_url',
        'header_type',
        'url_button_text',
        'header_text',
        'body_text',
        'footer_text',
        'buttons',
        'examples',
        'is_approved',
        'status'
    ];

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
