<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class University extends Model
{
    protected $table = 'universities';

    protected $fillable = ['user_id', 'degree_category', 'type', 'degree_name', 'university_name', 'degree_category_icon', 'degree_description', 'deadline_date', 'degree_duration', 'helpline_number', 'degree_overview', 'key_highlight', 'career_outcome', 'compare_degree', 'free_copilot'];

    public $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(DegreeCategory::class, 'degree_category', 'id');
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
