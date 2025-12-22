<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = ['user_id', 'team_name'];


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
