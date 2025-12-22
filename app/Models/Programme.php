<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Programme extends Model
{
    protected $table = 'programmes';

    protected $fillable = ['user_id', 'degree_category', 'degree_title', 'programme_icon', 'degree_description', 'degree_inclusions', 'helpline_number', 'degree_overview', 'key_highlight', 'career_outcome', 'compare_degree', 'free_copilot', 'status'];

    public $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function programmes()
    {
        return $this->hasMany(Programme::class, 'degree_category', 'id');
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
