<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CourseTopic extends Model
{
    protected $table = 'course_topics';

    protected $fillable = ['course_id', 'topic', 'topic_headding', 'topic_content'];

    public $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
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
