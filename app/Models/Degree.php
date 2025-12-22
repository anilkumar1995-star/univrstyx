<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Degree extends Model
{
    protected $table = 'degree_list';

    protected $fillable = ['user_id', 'degree_name','category', 'university_name', 'university_icon','status'];

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
