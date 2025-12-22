<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FestivalDetail extends Model
{
    protected $table = 'holiday_list';

    protected $fillable = ['user_id', 'festival_date', 'festival_name', 'desc'];

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
