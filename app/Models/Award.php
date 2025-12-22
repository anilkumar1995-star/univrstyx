<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Award extends Model
{
    protected $table = 'award_acomplishments';

    protected $fillable =[
        'user_id', 'award_title', 'award_heading', 'award_description', 'award_image', 'status'
    ];
             
    public $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
