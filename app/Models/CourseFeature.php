<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CourseFeature extends Model
{
    protected $table = 'course_features';

    protected $fillable = ['course_id', 'feature_name', 'free_course', 'paid_course'];

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
