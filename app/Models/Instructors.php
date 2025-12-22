<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Instructors extends Model
{
    protected $table = 'instructors';

    protected $fillable =[
        'user_id', 'name', 'designation', 'status', 'working_at', 'working_logo', 'linkedin_url', 'description', 'profile_image'
    ];

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

       