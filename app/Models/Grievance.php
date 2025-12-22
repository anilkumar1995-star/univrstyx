<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grievance extends Model
{
    protected $table = 'grievances';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'mobile',
        'alt_mobile',
        'subject',
        'message',
        'attachment',
        'status',
    ];


    // protected $casts = [
    //     'step_data' => 'array',
    // ];

    public $with = ['course'];

    public function course()
    {
        return $this->belongsTo(University::class, 'course_id', 'id');
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
