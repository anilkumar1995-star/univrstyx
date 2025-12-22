<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    protected $table = 'homepage_settings';
    protected $fillable = [
        'user_id',
        'trending_title',
        'trending_subtitle',
        'verticals_title',
        'verticals_subtitle',
        'free_courses_title',
        'free_courses_subtitle',
        'testimonials_title',
        'testimonials_subtitle',
        'awards_title',
        'support_title',
        'support_subtitle',
        'building_careers',
        'partner_heading_1',
        'partner_heading_2',
        'instructor_heading_1',
        'instructor_heading_2',
        'instructor_subtitle',
        'media_heading',
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
