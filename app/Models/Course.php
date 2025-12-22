<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    protected $table = 'course_list';

    protected $fillable =[
        'user_id', 'course_category', 'course_title', 'course_learners','course_hours','course_related', 'course_icon', 'course_description',
        'free_certificate', 'is_share', 'helpline_number','status',
        'certificate_intro','certificate_img', 'keybenefit_content', 'who_enroll', 'why_choose_course'
    ];
            public function topics()
        {
            return $this->hasMany(CourseTopic::class, 'course_id', 'id');
        }

        public function features()
        {
            return $this->hasMany(CourseFeature::class, 'course_id', 'id');
        }

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
