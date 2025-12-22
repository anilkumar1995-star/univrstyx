<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DegreeCategory extends Model
{
    protected $table = 'degree_category';

    protected $fillable = ['user_id', 'degree_category','category', 'degree_category_slug', 'degree_category_icon'];

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
